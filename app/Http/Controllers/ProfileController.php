<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\AuditLog;
use App\Models\BespokeFormula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Show customer profile view.
     */
    public function index()
    {
        $user = Auth::user();
        $orders = $user->orders()->with('items')->get();
        $addresses = $user->addresses()->get();
        $formulas = $user->formulas()->get();

        return view('profile.index', compact('user', 'orders', 'addresses', 'formulas'));
    }

    /**
     * Update customer profile info.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name = $validated['name'];
        $user->phone = $validated['phone'];

        if (!empty($validated['new_password'])) {
            if (!Hash::check($validated['current_password'] ?? '', $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Current password entered is incorrect.',
                ], 422);
            }
            $user->password = Hash::make($validated['new_password']);
        }

        $user->save();

        AuditLog::create([
            'user_id' => $user->id,
            'action' => 'PROFILE_UPDATED',
            'details' => 'User profile updated',
            'ip_address' => $request->ip(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Sanctuary profile updated successfully.',
            'user' => $user,
        ]);
    }

    /**
     * Save new delivery address.
     */
    public function storeAddress(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:100',
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'pincode' => 'required|string|max:20',
            'is_default' => 'nullable|boolean',
        ]);

        $user = Auth::user();

        if ($request->boolean('is_default')) {
            $user->addresses()->update(['is_default' => false]);
        }

        $address = $user->addresses()->create([
            'label' => $validated['label'],
            'street' => $validated['street'],
            'city' => $validated['city'],
            'pincode' => $validated['pincode'],
            'is_default' => $request->boolean('is_default'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Sanctuary address added successfully.',
            'address' => $address,
        ]);
    }

    /**
     * Delete delivery address.
     */
    public function deleteAddress($id)
    {
        $user = Auth::user();
        $user->addresses()->where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Address removed.',
        ]);
    }

    /**
     * Save a bespoke fragrance formulation.
     */
    public function storeFormula(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'vessel' => 'required|string',
            'wick' => 'required|string',
            'top' => 'required|string',
            'heart' => 'required|string',
            'base' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $formula = Auth::user()->formulas()->create($validated);

        return response()->json([
            'success' => true,
            'message' => "Bespoke formula '{$formula->name}' committed to your private archive.",
            'formula' => $formula,
        ]);
    }

    /**
     * Delete bespoke formulation.
     */
    public function deleteFormula($id)
    {
        Auth::user()->formulas()->where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Formula removed from your private archive.',
        ]);
    }
}
