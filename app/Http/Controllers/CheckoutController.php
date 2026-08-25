<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('shop.index')->with('warning', 'Your cart is currently empty.');
        }

        $user = Auth::user();
        $addresses = $user->addresses()->latest()->get();
        $subtotal = 0;

        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $shippingFee = $subtotal > 1500 ? 0.00 : 99.00; // Free shipping over ₹1,500
        $totalAmount = $subtotal + $shippingFee;

        return view('checkout.index', compact('cart', 'user', 'addresses', 'subtotal', 'shippingFee', 'totalAmount'));
    }

    public function process(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('shop.index')->with('warning', 'Your cart is empty.');
        }

        $user = Auth::user();

        $request->validate([
            'address_id' => 'nullable',
            'payment_method' => 'required|in:COD,Online Payment',
            'notes' => 'nullable|string|max:500',
        ]);

        if ($request->filled('address_id')) {
            $addressModel = Address::where('id', $request->address_id)->where('user_id', $user->id)->firstOrFail();
            $shippingAddress = [
                'recipient_name' => $addressModel->recipient_name,
                'phone' => $addressModel->phone,
                'address_line1' => $addressModel->address_line1,
                'address_line2' => $addressModel->address_line2,
                'city' => $addressModel->city,
                'state' => $addressModel->state,
                'postal_code' => $addressModel->postal_code,
            ];
        } else {
            $request->validate([
                'recipient_name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'address_line1' => 'required|string|max:255',
                'address_line2' => 'nullable|string|max:255',
                'city' => 'required|string|max:100',
                'state' => 'required|string|max:100',
                'postal_code' => 'required|string|max:20',
            ]);

            $shippingAddress = [
                'recipient_name' => $request->recipient_name,
                'phone' => $request->phone,
                'address_line1' => $request->address_line1,
                'address_line2' => $request->address_line2,
                'city' => $request->city,
                'state' => $request->state,
                'postal_code' => $request->postal_code,
            ];

            if ($request->boolean('save_address')) {
                $user->addresses()->create($shippingAddress + ['is_default' => false]);
            }
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $shippingFee = $subtotal > 1500 ? 0.00 : 99.00;
        $totalAmount = $subtotal + $shippingFee;

        $orderNumber = 'ORD-' . rand(10000, 99999);

        $order = Order::create([
            'order_number' => $orderNumber,
            'user_id' => $user->id,
            'subtotal' => $subtotal,
            'shipping_fee' => $shippingFee,
            'total_amount' => $totalAmount,
            'status' => 'Order Placed',
            'payment_method' => $request->payment_method,
            'payment_status' => $request->payment_method === 'Online Payment' ? 'Paid' : 'Pending',
            'shipping_address' => $shippingAddress,
            'notes' => $request->notes,
        ]);

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'product_name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'subtotal' => $item['price'] * $item['quantity'],
                'custom_options' => $item['custom_options'] ?? null,
            ]);
        }

        Payment::create([
            'order_id' => $order->id,
            'transaction_id' => $request->payment_method === 'Online Payment' ? 'pay_rzp_' . Str::random(10) : null,
            'payment_gateway' => $request->payment_method,
            'amount' => $totalAmount,
            'status' => $request->payment_method === 'Online Payment' ? 'Success' : 'Pending',
        ]);

        // Clear cart
        session()->forget('cart');

        return redirect()->route('orders.show', $order->id)->with('success', "Order #{$order->order_number} placed successfully!");
    }
}
