<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Discount;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * Show Atelier Admin Dashboard.
     */
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->get();
        $orders = Order::with('items')->orderBy('id', 'desc')->get();
        $discounts = Discount::orderBy('id', 'desc')->get();
        $customers = User::where('role', 'customer')->withCount('orders')->orderBy('id', 'desc')->get();

        $stats = [
            'total_revenue' => Order::where('status_code', '!=', 'cancelled')->sum('total'),
            'total_orders' => Order::count(),
            'pending_orders' => Order::whereIn('status_code', ['pending', 'pouring'])->count(),
            'total_products' => Product::count(),
            'low_stock_count' => Product::where('stock', '<=', 10)->count(),
            'total_customers' => $customers->count(),
        ];

        return view('admin.index', compact('products', 'orders', 'discounts', 'customers', 'stats'));
    }

    /**
     * Store new product in catalog.
     */
    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'fragrance' => 'required|string',
            'top_notes' => 'nullable|string',
            'heart_notes' => 'nullable|string',
            'base_notes' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'burn_time' => 'required|string',
            'weight' => 'required|string',
            'badge' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'image' => 'required|url',
            'description' => 'required|string',
        ]);

        $validated['slug'] = Str::slug($validated['name']) . '-' . rand(10, 99);
        $product = Product::create($validated);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'PRODUCT_CREATED',
            'details' => "Added candle '{$product->name}' to inventory.",
            'ip_address' => $request->ip(),
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Candle '{$product->name}' added to inventory.",
                'product' => $product,
            ]);
        }

        return back()->with('success', "Candle '{$product->name}' added successfully.");
    }

    /**
     * Update product details.
     */
    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'fragrance' => 'required|string',
            'top_notes' => 'nullable|string',
            'heart_notes' => 'nullable|string',
            'base_notes' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'burn_time' => 'required|string',
            'weight' => 'required|string',
            'badge' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'image' => 'required|url',
            'description' => 'required|string',
        ]);

        $product->update($validated);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'PRODUCT_UPDATED',
            'details' => "Updated candle '{$product->name}'.",
            'ip_address' => $request->ip(),
        ]);

        return response()->json([
            'success' => true,
            'message' => "Candle '{$product->name}' updated successfully.",
            'product' => $product,
        ]);
    }

    /**
     * Delete product.
     */
    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $name = $product->name;
        $product->delete();

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'PRODUCT_DELETED',
            'details' => "Archived candle '{$name}'.",
            'ip_address' => request()->ip(),
        ]);

        return response()->json([
            'success' => true,
            'message' => "Candle '{$name}' removed from active archive.",
        ]);
    }

    /**
     * Update order status.
     */
    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|string',
            'status_code' => 'required|string',
            'status_desc' => 'nullable|string',
        ]);

        $order->update($validated);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'ORDER_STATUS_CHANGED',
            'details' => "Order #{$order->order_number} changed to {$order->status}.",
            'ip_address' => $request->ip(),
        ]);

        return response()->json([
            'success' => true,
            'message' => "Order #{$order->order_number} status updated to {$order->status}.",
            'order' => $order,
        ]);
    }

    /**
     * Create promo discount voucher.
     */
    public function storeDiscount(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:discounts,code|max:50',
            'type' => 'required|in:percent,fixed',
            'value' => 'required|numeric|min:1',
            'min_spend' => 'nullable|numeric|min:0',
        ]);

        $validated['code'] = strtoupper(trim($validated['code']));
        $discount = Discount::create($validated);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'DISCOUNT_CREATED',
            'details' => "Created voucher code '{$discount->code}'.",
            'ip_address' => $request->ip(),
        ]);

        return response()->json([
            'success' => true,
            'message' => "Voucher '{$discount->code}' activated.",
            'discount' => $discount,
        ]);
    }

    /**
     * Toggle discount status.
     */
    public function toggleDiscount($id)
    {
        $discount = Discount::findOrFail($id);
        $discount->is_active = !$discount->is_active;
        $discount->save();

        return response()->json([
            'success' => true,
            'message' => "Voucher '{$discount->code}' status changed.",
            'is_active' => $discount->is_active,
        ]);
    }
}
