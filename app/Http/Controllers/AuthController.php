<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Handle user login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $login = $credentials['login'];
        $cleanPhone = preg_replace('/\D/', '', $login);
        $user = User::where('email', $login)
            ->orWhere('username', $login)
            ->orWhere('phone', $login)
            ->when(!empty($cleanPhone) && strlen($cleanPhone) >= 7, function ($q) use ($cleanPhone) {
                $lastDigits = substr($cleanPhone, -10);
                $q->orWhereRaw("REPLACE(REPLACE(REPLACE(REPLACE(COALESCE(phone, ''), ' ', ''), '-', ''), '+', ''), '(', '') LIKE ?", ["%{$lastDigits}%"]);
            })
            ->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'The provided credentials do not match our archive records.',
                ], 422);
            }

            return back()->withErrors([
                'login' => 'The provided credentials do not match our archive records.',
            ])->withInput($request->only('login'));
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        AuditLog::create([
            'user_id' => $user->id,
            'action' => 'USER_LOGIN',
            'details' => "User {$user->name} ({$user->role}) logged in.",
            'ip_address' => $request->ip(),
        ]);

        // Determine destination based on role
        $redirectUrl = match ($user->role) {
            'superadmin' => route('superadmin.index'),
            'admin' => route('admin.index'),
            default => route('profile.index'),
        };

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Welcome back, {$user->name}",
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'username' => $user->username,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'role' => $user->role,
                    'tier' => $user->tier,
                    'points' => $user->points,
                ],
                'redirect' => $redirectUrl,
            ]);
        }

        return redirect()->intended($redirectUrl);
    }

    /**
     * Handle user registration.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|string|max:255',
            'username' => 'nullable|string|max:50|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $username = $validated['username'] ?? strtolower(explode(' ', $validated['name'])[0]) . rand(100, 999);
        $phone = $validated['phone'] ?? null;
        $email = $validated['email'] ?? ($username . '@sanctuary.in');
        if (User::where('email', $email)->exists()) {
            $email = $username . '.' . rand(100, 999) . '@sanctuary.in';
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $email,
            'username' => $username,
            'password' => Hash::make($validated['password']),
            'role' => 'customer',
            'tier' => 'VIP Collector',
            'points' => 100, // Welcome reward points
            'phone' => $phone,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        AuditLog::create([
            'user_id' => $user->id,
            'action' => 'USER_REGISTER',
            'details' => "New customer account created: {$user->email}",
            'ip_address' => $request->ip(),
        ]);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Welcome to Sondhi Atelier! Your membership is active.',
                'user' => $user,
                'redirect' => route('profile.index'),
            ]);
        }

        return redirect()->route('profile.index')->with('success', 'Welcome to Sondhi Atelier!');
    }

    /**
     * Handle user logout.
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            AuditLog::create([
                'user_id' => $user->id,
                'action' => 'USER_LOGOUT',
                'details' => "User {$user->name} logged out.",
                'ip_address' => $request->ip(),
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Signed out successfully.',
                'redirect' => route('home'),
            ]);
        }

        return redirect()->route('home')->with('info', 'You have been signed out.');
    }

    /**
     * Get currently authenticated user data.
     */
    public function currentUser(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['authenticated' => false, 'user' => null]);
        }

        $user = Auth::user()->load('addresses');

        return response()->json([
            'authenticated' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'role' => $user->role,
                'tier' => $user->tier,
                'points' => $user->points,
                'phone' => $user->phone,
                'addresses' => $user->addresses,
            ],
        ]);
    }

    /**
     * Format phone number to international E.164 standard.
     */
    protected function formatE164Phone(string $phone): string
    {
        $phone = trim($phone);
        if (str_starts_with($phone, '+')) {
            return '+' . preg_replace('/\D/', '', substr($phone, 1));
        }

        $clean = preg_replace('/\D/', '', $phone);
        if (strlen($clean) === 10) {
            return '+91' . $clean;
        }
        if (strlen($clean) === 11 && str_starts_with($clean, '0')) {
            return '+91' . substr($clean, 1);
        }
        if (strlen($clean) === 12 && str_starts_with($clean, '91')) {
            return '+' . $clean;
        }

        return '+' . $clean;
    }

    /**
     * Determine if real Twilio service is configured.
     */
    protected function hasTwilioConfig(): bool
    {
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $from = config('services.twilio.from');
        $verifySid = config('services.twilio.verify_sid');

        return !empty($sid) && !empty($token) && (!empty($from) || !empty($verifySid));
    }

    /**
     * Generate and dispatch an SMS OTP verification code.
     */
    public function sendOtp(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|string|min:7|max:30',
        ]);

        $rawPhone = trim($validated['phone']);
        $e164Phone = $this->formatE164Phone($rawPhone);
        $cleanPhoneDigits = preg_replace('/\D/', '', $e164Phone);

        if (strlen($cleanPhoneDigits) < 10) {
            return response()->json([
                'success' => false,
                'message' => 'Please provide a valid mobile number with at least 10 digits.',
            ], 422);
        }

        // Always generate a real 6-digit random code (100000 - 999999)
        $otp = (string) random_int(100000, 999999);

        // Store in Cache and Session under normalized phone digits
        $cacheKey = 'otp_' . $cleanPhoneDigits;
        Cache::put($cacheKey, $otp, now()->addMinutes(10));
        if ($request->hasSession()) {
            $request->session()->put($cacheKey, $otp);
        }

        $twilioSid = config('services.twilio.sid');
        $twilioToken = config('services.twilio.token');
        $twilioFrom = config('services.twilio.from');
        $twilioVerifySid = config('services.twilio.verify_sid');

        $isTwilioConfigured = $this->hasTwilioConfig();

        if ($isTwilioConfigured) {
            try {
                if (!empty($twilioVerifySid)) {
                    // Twilio Verify API v2
                    $verifyUrl = "https://verify.twilio.com/v2/Services/{$twilioVerifySid}/Verifications";
                    $response = Http::withBasicAuth($twilioSid, $twilioToken)
                        ->asForm()
                        ->post($verifyUrl, [
                            'To' => $e164Phone,
                            'Channel' => 'sms',
                        ]);

                    $resData = $response->json();
                    if (!$response->successful()) {
                        $errMsg = $resData['message'] ?? 'Twilio Verify service rejected request.';
                        Log::error("Twilio Verify dispatch error ({$response->status()}): " . json_encode($resData));
                        return response()->json([
                            'success' => false,
                            'message' => "Twilio Verify error: {$errMsg}",
                        ], 422);
                    }

                    Log::info("Twilio Verify SMS dispatched to {$e164Phone}, SID: " . ($resData['sid'] ?? 'N/A'));
                } else {
                    // Twilio Programmable SMS API with generated 6-digit OTP
                    $smsUrl = "https://api.twilio.com/2010-04-01/Accounts/{$twilioSid}/Messages.json";
                    $response = Http::withBasicAuth($twilioSid, $twilioToken)
                        ->asForm()
                        ->post($smsUrl, [
                            'From' => $twilioFrom,
                            'To' => $e164Phone,
                            'Body' => "Your Sondhi Atelier verification code is {$otp}. Valid for 10 minutes. Do not share this code.",
                        ]);

                    $resData = $response->json();
                    if (!$response->successful()) {
                        $errMsg = $resData['message'] ?? 'Twilio SMS failed to dispatch.';
                        Log::error("Twilio SMS dispatch failed ({$response->status()}): " . json_encode($resData));
                        return response()->json([
                            'success' => false,
                            'message' => "Twilio error: {$errMsg}",
                        ], 422);
                    }

                    Log::info("Twilio SMS successfully dispatched to {$e164Phone}, Message SID: " . ($resData['sid'] ?? 'N/A'));
                }

                // In live Twilio mode, DO NOT return the OTP in the JSON response
                return response()->json([
                    'success' => true,
                    'is_demo' => false,
                    'message' => "A 6-digit verification code was sent via SMS to {$e164Phone}.",
                    'phone' => $rawPhone,
                    'e164_phone' => $e164Phone,
                    'expires_in' => 600,
                ]);

            } catch (\Throwable $e) {
                Log::error("Twilio SMS dispatch exception: " . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Twilio network/connection failure: ' . $e->getMessage(),
                ], 500);
            }
        }

        // Demo fallback ONLY when Twilio API credentials are not provided in .env
        Log::info("Demo 6-digit SMS OTP generated for {$rawPhone} ({$e164Phone}): {$otp}");

        return response()->json([
            'success' => true,
            'is_demo' => true,
            'message' => "Demo mode: SMS code generated (configure Twilio in .env for real SMS delivery).",
            'phone' => $rawPhone,
            'e164_phone' => $e164Phone,
            'otp' => $otp,
            'expires_in' => 600,
        ]);
    }

    /**
     * Verify the entered SMS OTP code.
     */
    public function verifyOtp(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|string|min:7|max:30',
            'otp' => 'required|string|min:4|max:10',
        ]);

        $rawPhone = trim($validated['phone']);
        $e164Phone = $this->formatE164Phone($rawPhone);
        $cleanPhoneDigits = preg_replace('/\D/', '', $e164Phone);
        $inputOtp = trim($validated['otp']);

        $isTwilioConfigured = $this->hasTwilioConfig();
        $twilioVerifySid = config('services.twilio.verify_sid');

        $isValid = false;

        // If Twilio Verify service is active
        if ($isTwilioConfigured && !empty($twilioVerifySid)) {
            try {
                $twilioSid = config('services.twilio.sid');
                $twilioToken = config('services.twilio.token');
                $checkUrl = "https://verify.twilio.com/v2/Services/{$twilioVerifySid}/VerificationCheck";

                $response = Http::withBasicAuth($twilioSid, $twilioToken)
                    ->asForm()
                    ->post($checkUrl, [
                        'To' => $e164Phone,
                        'Code' => $inputOtp,
                    ]);

                $resData = $response->json();
                if ($response->successful() && ($resData['status'] ?? '') === 'approved') {
                    $isValid = true;
                } else {
                    Log::warning("Twilio Verify check rejected for {$e164Phone}: " . json_encode($resData));
                }
            } catch (\Throwable $e) {
                Log::error("Twilio Verify check exception: " . $e->getMessage());
            }
        } else {
            // Verify against cached 6-digit OTP
            $cacheKey = 'otp_' . $cleanPhoneDigits;
            $cachedOtp = Cache::get($cacheKey) ?: ($request->hasSession() ? $request->session()->get($cacheKey) : null);

            if ($cachedOtp && $cachedOtp === $inputOtp) {
                $isValid = true;
                Cache::forget($cacheKey);
            } elseif (!$isTwilioConfigured && in_array($inputOtp, ['8421', '842100', '123456'])) {
                // Demo fallback only allowed when Twilio is NOT configured
                $isValid = true;
            }
        }

        if (!$isValid) {
            return response()->json([
                'success' => false,
                'message' => 'The entered verification code is incorrect or expired. Please check and try again.',
            ], 422);
        }

        if ($request->hasSession()) {
            $request->session()->put('verified_phone_' . $cleanPhoneDigits, true);
        }

        return response()->json([
            'success' => true,
            'message' => 'Mobile number verified successfully.',
            'phone' => $rawPhone,
            'e164_phone' => $e164Phone,
            'verified' => true,
        ]);
    }
}
