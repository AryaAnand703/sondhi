<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Discount;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Place order from current cart.
     */
    public function checkout(Request $request)
    {
        $cart = $request->session()->get('cart', []);

        if (empty($cart)) {
            return response()->json([
                'success' => false,
                'message' => 'Your sanctuary basket is currently empty.',
            ], 422);
        }

        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'shipping_address' => 'required|string',
            'payment_method' => 'nullable|string',
        ]);

        $user = Auth::user();
        $discountCode = $request->session()->get('discount_code');

        $subtotal = 0;
        $itemsCount = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
            $itemsCount += $item['quantity'];
        }

        $discountAmount = 0;
        if ($discountCode) {
            $discount = Discount::where('code', $discountCode)->where('is_active', true)->first();
            if ($discount && $subtotal >= $discount->min_spend) {
                if ($discount->type === 'percent') {
                    $discountAmount = round(($subtotal * ($discount->value / 100)), 2);
                } else {
                    $discountAmount = min($discount->value, $subtotal);
                }
            }
        }

        $shipping = $subtotal > 1500 ? 0 : 99;
        $total = max(0, $subtotal - $discountAmount + $shipping);

        $orderNumber = 'SND-' . rand(1000, 9999);

        DB::beginTransaction();
        try {
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => $user?->id,
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'status' => 'Pouring & Curing',
                'status_code' => 'pouring',
                'status_desc' => 'Hand-poured with botanical soy wax, entering 48-hour curing chamber',
                'items_count' => $itemsCount,
                'subtotal' => $subtotal,
                'discount_amount' => $discountAmount,
                'total' => $total,
                'estimated_delivery' => now()->addDays(7)->format('M d, Y'),
                'shipping_address' => $validated['shipping_address'],
                'payment_method' => $validated['payment_method'] ?? 'Prepaid Card / UPI',
            ]);

            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'product_name' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);

                // Reduce inventory stock if tracked
                $product = Product::find($item['id']);
                if ($product && $product->stock > 0) {
                    $product->decrement('stock', $item['quantity']);
                }
            }

            // Award customer points (10% of total spend)
            if ($user) {
                $earnedPoints = (int) round($total * 0.1);
                $user->increment('points', $earnedPoints);
            }

            // Record audit log
            AuditLog::create([
                'user_id' => $user?->id,
                'action' => 'ORDER_CREATED',
                'details' => "Order {$order->order_number} placed for ₹{$total}",
                'ip_address' => $request->ip(),
            ]);

            // Clear session cart
            $request->session()->forget(['cart', 'discount_code']);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Your bespoke sanctuary commission has been received with gratitude.',
                'order_number' => $order->order_number,
                'total' => $order->total,
                'order' => $order->load('items'),
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to process commission: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Track order by order number.
     */
    public function track($orderNumber)
    {
        $order = Order::with('items')->where('order_number', $orderNumber)->firstOrFail();

        return response()->json($order);
    }
}
