<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentWebhookController;
use App\Http\Controllers\Customer\AuthController as CustomerAuthController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\WishlistController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\InventoryController as AdminInventoryController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Admin\ContentController as AdminContentController;

/*
|--------------------------------------------------------------------------
| Public Storefront & Brand
|--------------------------------------------------------------------------
*/
Route::get('/', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop', [ShopController::class, 'catalog'])->name('shop.catalog');
Route::get('/shop/{category}', [ShopController::class, 'catalog'])->name('shop.category');
Route::get('/product/{slug}', [ShopController::class, 'show'])->name('shop.show');
Route::get('/maison', [ShopController::class, 'maison'])->name('shop.maison');

/*
|--------------------------------------------------------------------------
| Shopping Bag
|--------------------------------------------------------------------------
*/
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/data', [CartController::class, 'data'])->name('cart.data');

/*
|--------------------------------------------------------------------------
| Wishlist
|--------------------------------------------------------------------------
*/
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

/*
|--------------------------------------------------------------------------
| Checkout & Nigerian Payment Pipeline
|--------------------------------------------------------------------------
*/
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/calculate', [CheckoutController::class, 'calculate'])->name('checkout.calculate');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/verify/{reference}', [CheckoutController::class, 'verify'])->name('checkout.verify');
Route::get('/checkout/simulate/{reference}', [CheckoutController::class, 'simulate'])->name('checkout.simulate.paystack');
Route::get('/order/{orderNumber}/confirmed', [CheckoutController::class, 'success'])->name('checkout.success');

/*
|--------------------------------------------------------------------------
| Payment Webhooks (CSRF Exempt)
|--------------------------------------------------------------------------
*/
Route::post('/api/webhooks/paystack', [PaymentWebhookController::class, 'paystack'])->name('webhook.paystack');
Route::post('/api/webhooks/flutterwave', [PaymentWebhookController::class, 'flutterwave'])->name('webhook.flutterwave');

/*
|--------------------------------------------------------------------------
| Customer Authentication & Account Portal
|--------------------------------------------------------------------------
*/
Route::prefix('customer')->name('customer.')->group(function () {
    Route::get('/login', [CustomerAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [CustomerAuthController::class, 'login'])->name('login.post');
    Route::get('/register', [CustomerAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [CustomerAuthController::class, 'register'])->name('register.post');
    Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('logout');
});

Route::middleware('customer')->prefix('account')->name('customer.')->group(function () {
    Route::get('/', [CustomerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/orders', [CustomerDashboardController::class, 'orders'])->name('orders');
    Route::get('/orders/{orderNumber}', [CustomerDashboardController::class, 'orderDetail'])->name('orders.show');
    Route::get('/addresses', [CustomerDashboardController::class, 'addresses'])->name('addresses');
    Route::post('/addresses', [CustomerDashboardController::class, 'storeAddress'])->name('addresses.store');
});

/*
|--------------------------------------------------------------------------
| Admin Command Center
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');

    Route::middleware('admin')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Products
        Route::resource('products', AdminProductController::class);

        // Orders
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');

        // Inventory
        Route::get('/inventory', [AdminInventoryController::class, 'index'])->name('inventory.index');
        Route::post('/inventory/{inventory}', [AdminInventoryController::class, 'update'])->name('inventory.update');

        // Coupons
        Route::get('/coupons', [AdminCouponController::class, 'index'])->name('coupons.index');
        Route::post('/coupons', [AdminCouponController::class, 'store'])->name('coupons.store');
        Route::delete('/coupons/{coupon}', [AdminCouponController::class, 'destroy'])->name('coupons.destroy');

        // Content Management
        Route::get('/content', [AdminContentController::class, 'index'])->name('content.index');
        Route::post('/content', [AdminContentController::class, 'update'])->name('content.update');

        // Database & phpMyAdmin Direct Access
        Route::get('/database', function () {
            return redirect('/phpmyadmin/index.php?route=/database/structure&db=fortunes_collection');
        })->name('database');
    });
});
