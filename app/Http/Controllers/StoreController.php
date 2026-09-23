<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Display the storefront.
     */
    public function index()
    {
        $products = Product::where('is_active', true)->orderBy('id', 'asc')->get();
        $categories = $products->pluck('category')->unique()->values();

        return view('store.index', compact('products', 'categories'));
    }

    /**
     * Get products as JSON for dynamic store logic / modals.
     */
    public function apiProducts(Request $request)
    {
        $query = Product::where('is_active', true);

        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        $products = $query->orderBy('id', 'asc')->get();

        return response()->json($products);
    }

    /**
     * Get specific product details.
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);

        if (request()->wantsJson()) {
            return response()->json($product);
        }

        return view('store.show', compact('product'));
    }
}
