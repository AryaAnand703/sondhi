<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Auth::user()->orders()->with(['items.product'])->latest();

        $activeStatus = $request->get('status', 'all');

        if ($activeStatus === 'in_progress') {
            $query->whereNotIn('status', ['Delivered', 'Cancelled']);
        } elseif ($activeStatus === 'delivered') {
            $query->where('status', 'Delivered');
        } elseif ($activeStatus === 'cancelled') {
            $query->where('status', 'Cancelled');
        }

        $orders = $query->get();

        $stats = [
            'all' => Auth::user()->orders()->count(),
            'in_progress' => Auth::user()->orders()->whereNotIn('status', ['Delivered', 'Cancelled'])->count(),
            'delivered' => Auth::user()->orders()->where('status', 'Delivered')->count(),
            'cancelled' => Auth::user()->orders()->where('status', 'Cancelled')->count(),
        ];

        return view('orders.index', compact('orders', 'stats', 'activeStatus'));
    }

    public function show($id)
    {
        $order = Order::where('id', $id)->where('user_id', Auth::id())->with(['items.product', 'payment'])->firstOrFail();

        // Steps pipeline map with titles, icons, and detailed context
        $allSteps = [
            [
                'title' => 'Order Placed',
                'description' => 'Order received & logged in our system.',
                'icon' => 'fa-receipt',
            ],
            [
                'title' => 'Payment Confirmed',
                'description' => 'Payment transaction verified.',
                'icon' => 'fa-shield-check',
            ],
            [
                'title' => 'Processing',
                'description' => 'Preparing items & artisan quality checks.',
                'icon' => 'fa-boxes-stacked',
            ],
            [
                'title' => 'Packed',
                'description' => 'Securely packaged in luxury gift wrap.',
                'icon' => 'fa-box',
            ],
            [
                'title' => 'Shipped',
                'description' => 'Handed over to courier express partner.',
                'icon' => 'fa-truck-fast',
            ],
            [
                'title' => 'Delivered',
                'description' => 'Package successfully delivered.',
                'icon' => 'fa-house-circle-check',
            ],
        ];

        $stepTitles = array_column($allSteps, 'title');
        $currentStepIndex = array_search($order->status, $stepTitles);
        if ($currentStepIndex === false) {
            $currentStepIndex = 0;
        }

        return view('orders.show', compact('order', 'allSteps', 'currentStepIndex'));
    }
}

