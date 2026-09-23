<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        $user = User::where('email', $login)
            ->orWhere('username', $login)
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
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'nullable|string|max:50|unique:users',
            'password' => 'required|string|min:6',
            'phone' => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'username' => $validated['username'] ?? strtolower(explode(' ', $validated['name'])[0]) . rand(100, 999),
            'password' => Hash::make($validated['password']),
            'role' => 'customer',
            'tier' => 'VIP Collector',
            'points' => 100, // Welcome reward points
            'phone' => $validated['phone'] ?? null,
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
}
