<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SuperAdminController extends Controller
{
    /**
     * Show Sovereign Superadmin Control Center.
     */
    public function index()
    {
        $users = User::withCount('orders')->orderBy('id', 'asc')->get();
        $auditLogs = AuditLog::with('user')->orderBy('id', 'desc')->take(50)->get();

        $kpis = [
            'gross_revenue' => Order::where('status_code', '!=', 'cancelled')->sum('total'),
            'total_users' => $users->count(),
            'total_customers' => $users->where('role', 'customer')->count(),
            'total_admins' => $users->where('role', 'admin')->count(),
            'total_superadmins' => $users->where('role', 'superadmin')->count(),
            'total_orders' => Order::count(),
            'total_products' => Product::count(),
            'db_size' => 'Active (MySQL 8.4)',
        ];

        return view('superadmin.index', compact('users', 'auditLogs', 'kpis'));
    }

    /**
     * Update user role (promote/demote).
     */
    public function updateUserRole(Request $request, $id)
    {
        $targetUser = User::findOrFail($id);

        $validated = $request->validate([
            'role' => 'required|in:customer,admin,superadmin',
        ]);

        // Prevent removing the last superadmin
        if ($targetUser->role === 'superadmin' && $validated['role'] !== 'superadmin') {
            $superadminCount = User::where('role', 'superadmin')->count();
            if ($superadminCount <= 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot demote the sole system governor.',
                ], 422);
            }
        }

        $oldRole = $targetUser->role;
        $targetUser->role = $validated['role'];
        if ($targetUser->role === 'admin' && $targetUser->tier === 'VIP Collector') {
            $targetUser->tier = 'Master Artisan & Manager';
        } elseif ($targetUser->role === 'superadmin') {
            $targetUser->tier = 'Super Admin';
        }
        $targetUser->save();

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'ROLE_CHANGE',
            'details' => "Changed user '{$targetUser->name}' from {$oldRole} to {$targetUser->role}.",
            'ip_address' => $request->ip(),
        ]);

        return response()->json([
            'success' => true,
            'message' => "Role for '{$targetUser->name}' updated to {$targetUser->role}.",
            'user' => $targetUser,
        ]);
    }

    /**
     * Adjust user loyalty points.
     */
    public function updateUserPoints(Request $request, $id)
    {
        $targetUser = User::findOrFail($id);

        $validated = $request->validate([
            'points' => 'required|integer|min:0',
        ]);

        $oldPoints = $targetUser->points;
        $targetUser->points = $validated['points'];
        $targetUser->save();

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'POINTS_ADJUSTMENT',
            'details' => "Adjusted points for {$targetUser->name} from {$oldPoints} to {$targetUser->points}.",
            'ip_address' => $request->ip(),
        ]);

        return response()->json([
            'success' => true,
            'message' => "Loyalty points for {$targetUser->name} updated to {$targetUser->points}.",
            'user' => $targetUser,
        ]);
    }

    /**
     * Delete user account.
     */
    public function deleteUser($id)
    {
        $targetUser = User::findOrFail($id);

        if ($targetUser->id === Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Self-termination of governor account is prohibited.',
            ], 422);
        }

        $name = $targetUser->name;
        $targetUser->delete();

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'USER_PURGED',
            'details' => "Purged user account '{$name}'.",
            'ip_address' => request()->ip(),
        ]);

        return response()->json([
            'success' => true,
            'message' => "User account '{$name}' has been purged from system archives.",
        ]);
    }

    /**
     * Clear audit logs.
     */
    public function clearAuditLogs()
    {
        AuditLog::truncate();

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'LOGS_CLEARED',
            'details' => 'Sovereign governor purged historical audit logs.',
            'ip_address' => request()->ip(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Audit log history archived and reset.',
        ]);
    }
}
