<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'custom_options' => 'nullable|string|max:500',
        ]);

        $product = Product::findOrFail($request->product_id);
        $quantity = (int) $request->quantity;

        $price = $product->price;

        $cart = session()->get('cart', []);
        $cartId = $product->id;

        if (isset($cart[$cartId])) {
            $cart[$cartId]['quantity'] += $quantity;
            $cart[$cartId]['price'] = $product->price;
            if ($request->filled('custom_options')) {
                $cart[$cartId]['custom_options'] = $request->custom_options;
            }
        } else {
            $cart[$cartId] = [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => $price,
                'quantity' => $quantity,
                'image_path' => $product->image_path,
                'custom_options' => $request->custom_options,
            ];
        }

        session()->put('cart', $cart);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'cart_count' => array_sum(array_column($cart, 'quantity')),
                'message' => 'Product added to cart!',
            ]);
        }

        return back()->with('success', "'{$product->name}' added to cart!");
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);
        $productId = $request->product_id;

        if (isset($cart[$productId])) {
            $product = Product::find($productId);
            $newQty = (int) $request->quantity;
            $cart[$productId]['quantity'] = $newQty;

            if ($product) {
                $cart[$productId]['price'] = $product->price;
            }

            session()->put('cart', $cart);
        }

        return back()->with('success', 'Cart updated successfully.');
    }

    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
        ]);

        $cart = session()->get('cart', []);
        if (isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Item removed from cart.');
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Cart cleared.');
    }
}
