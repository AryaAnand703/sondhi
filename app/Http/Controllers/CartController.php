<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Get current cart contents and pricing summary.
     */
    public function getCart(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        $discountCode = $request->session()->get('discount_code');
        $summary = $this->calculateSummary($cart, $discountCode);

        return response()->json([
            'items' => array_values($cart),
            'summary' => $summary,
        ]);
    }

    /**
     * Add product to cart.
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $qty = $request->input('quantity', 1);

        $cart = $request->session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $qty;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => (float) $product->price,
                'weight' => $product->weight,
                'image' => $product->image,
                'category' => $product->category,
                'quantity' => $qty,
            ];
        }

        $request->session()->put('cart', $cart);
        $summary = $this->calculateSummary($cart, $request->session()->get('discount_code'));

        return response()->json([
            'success' => true,
            'message' => "Added {$product->name} to sanctuary cart.",
            'items' => array_values($cart),
            'summary' => $summary,
        ]);
    }

    /**
     * Update quantity of item in cart.
     */
    public function updateQuantity(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:0',
        ]);

        $productId = $request->product_id;
        $qty = $request->quantity;

        $cart = $request->session()->get('cart', []);

        if ($qty <= 0) {
            unset($cart[$productId]);
        } elseif (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $qty;
        }

        $request->session()->put('cart', $cart);
        $summary = $this->calculateSummary($cart, $request->session()->get('discount_code'));

        return response()->json([
            'success' => true,
            'items' => array_values($cart),
            'summary' => $summary,
        ]);
    }

    /**
     * Remove item from cart.
     */
    public function removeFromCart(Request $request)
    {
        $request->validate(['product_id' => 'required|integer']);

        $cart = $request->session()->get('cart', []);
        unset($cart[$request->product_id]);
        $request->session()->put('cart', $cart);

        $summary = $this->calculateSummary($cart, $request->session()->get('discount_code'));

        return response()->json([
            'success' => true,
            'items' => array_values($cart),
            'summary' => $summary,
        ]);
    }

    /**
     * Apply coupon / promo discount code.
     */
    public function applyDiscount(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        $code = strtoupper(trim($request->code));
        $discount = Discount::where('code', $code)->where('is_active', true)->first();

        if (!$discount) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired reservation voucher.',
            ], 422);
        }

        $cart = $request->session()->get('cart', []);
        $subtotal = array_reduce($cart, fn($acc, $item) => $acc + ($item['price'] * $item['quantity']), 0);

        if ($subtotal < $discount->min_spend) {
            return response()->json([
                'success' => false,
                'message' => "This voucher requires a minimum sanctuary spend of ₹{$discount->min_spend}.",
            ], 422);
        }

        $request->session()->put('discount_code', $discount->code);
        $summary = $this->calculateSummary($cart, $discount->code);

        return response()->json([
            'success' => true,
            'message' => "Voucher {$discount->code} applied successfully!",
            'discount' => $discount,
            'summary' => $summary,
        ]);
    }

    /**
     * Calculate cart totals and discounts.
     */
    protected function calculateSummary(array $cart, ?string $discountCode): array
    {
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

        $shipping = $subtotal > 1500 || $subtotal === 0 ? 0 : 99;
        $total = max(0, $subtotal - $discountAmount + $shipping);

        return [
            'items_count' => $itemsCount,
            'subtotal' => $subtotal,
            'discount_code' => $discountCode,
            'discount_amount' => $discountAmount,
            'shipping' => $shipping,
            'total' => $total,
        ];
    }
}
