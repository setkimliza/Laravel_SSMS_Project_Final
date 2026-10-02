<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\SalesController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Auth\CustomerAuthController;
use App\Http\Controllers\Auth\StaffAuthController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\StoreController;
use App\Http\Controllers\Stock\CategoryController;
use App\Http\Controllers\Stock\ProductController;
use App\Http\Controllers\Stock\StockDashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Storefront & Customer Catalog Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [StoreController::class, 'index'])->name('home');
Route::get('/catalog', [StoreController::class, 'catalog'])->name('catalog');
Route::get('/product/{id}', [StoreController::class, 'productDetail'])->name('product.detail');

/*
|--------------------------------------------------------------------------
| Shopping Cart Routes
|--------------------------------------------------------------------------
*/
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

/*
|--------------------------------------------------------------------------
| Customer Authentication Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest:web')->group(function () {
    Route::get('/login', [CustomerAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [CustomerAuthController::class, 'login']);
    Route::get('/register', [CustomerAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [CustomerAuthController::class, 'register']);
});
Route::match(['get', 'post'], '/logout', [CustomerAuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Authenticated Customer Checkout & Orders
|--------------------------------------------------------------------------
*/
Route::middleware('auth:web')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success/{id}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/orders', [CheckoutController::class, 'history'])->name('orders.history');
    Route::get('/orders/{id}', [CheckoutController::class, 'detail'])->name('orders.detail');
});

/*
|--------------------------------------------------------------------------
| Staff Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/staff/login', [StaffAuthController::class, 'showLoginForm'])->name('staff.login');
Route::post('/staff/login', [StaffAuthController::class, 'login']);
Route::match(['get', 'post'], '/staff/logout', [StaffAuthController::class, 'logout'])->name('staff.logout');

if (app()->environment('local')) {
    Route::get('/dev-login-admin', function () {
        $admin = \App\Models\Staff::where('Role', 'Admin')->first();
        if ($admin) {
            \Illuminate\Support\Facades\Auth::guard('staff')->login($admin);
        }
        return redirect()->route('admin.dashboard');
    });
}

/*
|--------------------------------------------------------------------------
| Admin Portal (Role: Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['staff.role:Admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Staff Management CRUD
    Route::resource('staff', StaffController::class)->except(['show']);

    // Sales & Reports
    Route::get('/sales', [SalesController::class, 'index'])->name('sales.index');
    Route::get('/orders', [SalesController::class, 'orders'])->name('orders.index');
    Route::get('/orders/{id}', [SalesController::class, 'showOrder'])->name('orders.show');
    Route::post('/orders/{id}/status', [SalesController::class, 'updateOrderStatus'])->name('orders.status');
});

/*
|--------------------------------------------------------------------------
| Stock & Inventory Control (Roles: Admin, Stock)
|--------------------------------------------------------------------------
*/
Route::middleware(['staff.role:Admin,Stock'])->prefix('stock')->name('stock.')->group(function () {
    Route::get('/dashboard', [StockDashboardController::class, 'index'])->name('dashboard');
    Route::get('/alerts', [StockDashboardController::class, 'inventoryAlerts'])->name('alerts');

    // Category Management CRUD
    Route::resource('categories', CategoryController::class)->except(['show']);

    // Product Management CRUD & Stock quick adjustments
    Route::resource('products', ProductController::class)->except(['show']);
    Route::post('/products/{id}/quick-stock', [ProductController::class, 'quickStockUpdate'])->name('products.quick-stock');
    Route::post('/products/{id}/discard-expired', [ProductController::class, 'discardExpired'])->name('products.discard-expired');
});
