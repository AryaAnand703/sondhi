<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::where('role', 'user')
            ->withCount('orders')
            ->withSum('orders as total_spent', 'total_amount')
            ->latest()
            ->paginate(15);

        return view('admin.customers.index', compact('customers'));
    }

    public function show(User $customer)
    {
        if ($customer->role === 'admin') {
            return redirect()->route('admin.customers.index');
        }

        $customer->load(['addresses', 'orders.items', 'supportTickets']);
        return view('admin.customers.show', compact('customer'));
    }
}
