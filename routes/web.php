<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\SuperAdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Sondhi Atelier
|--------------------------------------------------------------------------
*/

// Public Storefront & Catalog
Route::get('/', [StoreController::class, 'index'])->name('home');
Route::get('/products/{id}', [StoreController::class, 'show'])->name('products.show');
Route::get('/api/products', [StoreController::class, 'apiProducts'])->name('api.products');

// Shopping Cart (Session-backed)
Route::prefix('api/cart')->group(function () {
    Route::get('/', [CartController::class, 'getCart'])->name('cart.get');
    Route::post('/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/update', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::post('/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/discount', [CartController::class, 'applyDiscount'])->name('cart.discount');
});

// Checkout & Order Tracking
Route::post('/api/checkout', [OrderController::class, 'checkout'])->name('order.checkout');
Route::get('/api/track/{orderNumber}', [OrderController::class, 'track'])->name('order.track');

// Authentication Routes
Route::post('/auth/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth/register', [AuthController::class, 'register'])->name('register');
Route::post('/auth/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/auth/me', [AuthController::class, 'currentUser'])->name('auth.me');
Route::post('/api/auth/send-otp', [AuthController::class, 'sendOtp'])->name('api.auth.send_otp');
Route::post('/api/auth/verify-otp', [AuthController::class, 'verifyOtp'])->name('api.auth.verify_otp');
Route::post('/auth/send-otp', [AuthController::class, 'sendOtp']);
Route::post('/auth/verify-otp', [AuthController::class, 'verifyOtp']);

// Authenticated Customer Profile & Orders Section
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
Route::get('/orders', function () {
    return redirect('/profile#orders');
})->name('orders.index');

Route::middleware('auth')->group(function () {
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/addresses', [ProfileController::class, 'storeAddress'])->name('profile.address.store');
    Route::delete('/profile/addresses/{id}', [ProfileController::class, 'deleteAddress'])->name('profile.address.delete');
    Route::post('/profile/formulas', [ProfileController::class, 'storeFormula'])->name('profile.formula.store');
    Route::delete('/profile/formulas/{id}', [ProfileController::class, 'deleteFormula'])->name('profile.formula.delete');
});

// Artisan & Manager Admin Portal
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('admin.products.store');
    Route::put('/products/{id}', [AdminController::class, 'updateProduct'])->name('admin.products.update');
    Route::delete('/products/{id}', [AdminController::class, 'deleteProduct'])->name('admin.products.delete');
    Route::post('/orders/{id}/status', [AdminController::class, 'updateOrderStatus'])->name('admin.orders.status');
    Route::post('/discounts', [AdminController::class, 'storeDiscount'])->name('admin.discounts.store');
    Route::post('/discounts/{id}/toggle', [AdminController::class, 'toggleDiscount'])->name('admin.discounts.toggle');
});

// Sovereign Superadmin Control Center
Route::middleware(['auth', 'role:superadmin'])->prefix('superadmin')->group(function () {
    Route::get('/', [SuperAdminController::class, 'index'])->name('superadmin.index');
    Route::post('/users/{id}/role', [SuperAdminController::class, 'updateUserRole'])->name('superadmin.users.role');
    Route::post('/users/{id}/points', [SuperAdminController::class, 'updateUserPoints'])->name('superadmin.users.points');
    Route::delete('/users/{id}', [SuperAdminController::class, 'deleteUser'])->name('superadmin.users.delete');
    Route::post('/logs/clear', [SuperAdminController::class, 'clearAuditLogs'])->name('superadmin.logs.clear');
});
