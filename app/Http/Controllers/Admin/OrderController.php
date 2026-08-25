<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $orders = $query->latest()->paginate(15)->withQueryString();

        $stats = [
            'total' => Order::count(),
            'pending' => Order::whereNotIn('status', ['Delivered', 'Cancelled'])->count(),
            'delivered' => Order::where('status', 'Delivered')->count(),
            'revenue' => Order::where('payment_status', 'Paid')->sum('total_amount'),
        ];

        return view('admin.orders.index', compact('orders', 'stats'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product', 'payment']);
        $statuses = ['Order Placed', 'Payment Confirmed', 'Processing', 'Packed', 'Shipped', 'Delivered', 'Cancelled'];

        $currentIndex = array_search($order->status, $statuses);
        $nextStatus = null;
        if ($currentIndex !== false && $currentIndex < 5 && $order->status !== 'Cancelled') {
            $nextStatus = $statuses[$currentIndex + 1];
        }

        return view('admin.orders.show', compact('order', 'statuses', 'nextStatus'));
    }


    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:Order Placed,Payment Confirmed,Processing,Packed,Shipped,Delivered,Cancelled',
        ]);

        $order->update([
            'status' => $request->status,
        ]);

        if ($request->status === 'Delivered' && $order->payment_method === 'COD') {
            $order->update(['payment_status' => 'Paid']);
            if ($order->payment) {
                $order->payment->update(['status' => 'Success']);
            }
        }

        return back()->with('success', "Order #{$order->order_number} status updated to '{$request->status}'.");
    }
}
