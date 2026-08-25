<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\SupportTicket;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRevenue = Order::where('payment_status', 'Paid')->sum('total_amount');
        $totalOrders = Order::count();
        $pendingOrdersCount = Order::whereIn('status', ['Order Placed', 'Payment Confirmed', 'Processing'])->count();
        $totalCustomers = User::where('role', 'user')->count();
        $totalProducts = Product::count();
        $openSupportTickets = SupportTicket::whereIn('status', ['Open', 'In Progress'])->count();

        $recentOrders = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalOrders',
            'pendingOrdersCount',
            'totalCustomers',
            'totalProducts',
            'openSupportTickets',
            'recentOrders'
        ));
    }
}

