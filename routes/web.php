<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PizzaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

// ==========================================
// PUBLIC ROUTES
// ==========================================

// Pizza Shop Routes
Route::get('/', [PizzaController::class, 'index'])->name('shop.index');
Route::get('/pizza/{pizza}', [PizzaController::class, 'show'])->name('shop.show');
Route::get('/cart', [PizzaController::class, 'cart'])->name('shop.cart');

// API Routes for Cart
Route::post('/api/cart/add', [PizzaController::class, 'addToCart'])->name('api.cart.add');
Route::get('/api/cart', [PizzaController::class, 'getCartData'])->name('api.cart.get');

// Order Tracking (Public)
Route::get('/track-order', [OrderController::class, 'trackByNumber'])->name('orders.track-public');

// ==========================================
// AUTHENTICATION ROUTES (Google OAuth)
// ==========================================

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
});

Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');
Route::post('/logout', [GoogleAuthController::class, 'logout'])->name('logout');

// ==========================================
// AUTHENTICATED USER ROUTES
// ==========================================

Route::middleware('auth')->group(function () {
    // Checkout page (requires auth)
    Route::get('/checkout', [PizzaController::class, 'checkout'])->name('shop.checkout');

    // Checkout API (requires auth)
    Route::post('/api/checkout', [OrderController::class, 'store'])->name('api.checkout');

    // User Orders
    Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('orders.index');
    Route::get('/orders/{order}/track', [OrderController::class, 'track'])->name('orders.track');
});

// ==========================================
// ADMIN ROUTES
// ==========================================

Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Products (Pizzas)
        Route::resource('products', ProductController::class)
            ->parameters(['products' => 'pizza']);
        Route::post('/products/{pizza}/toggle-visibility', [ProductController::class, 'toggleVisibility'])->name('products.toggle-visibility');
        Route::post('/products/{pizza}/toggle-availability', [ProductController::class, 'toggleAvailability'])->name('products.toggle-availability');
        Route::post('/products/update-order', [ProductController::class, 'updateOrder'])->name('products.update-order');

        // Orders
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');

        // Sales Reports
        Route::get('/reports/sales', [AdminOrderController::class, 'salesReport'])->name('reports.sales');
    });
