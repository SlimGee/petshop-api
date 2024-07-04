<?php

use App\Http\Controllers\Auth\LoggedinUserController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetTokenController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Main\PostController;
use App\Http\Controllers\Main\PromotionController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DownloadInvoiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderStatusController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShipmentLocatorController;
use App\Http\Controllers\UserOrderController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/user/create', [RegistrationController::class, 'store'])->name('register');
    Route::post('/user/login', [LoggedinUserController::class, 'store'])->name('login');

    Route::post('/user/forgot-password', [PasswordResetTokenController::class, 'store'])
        ->name('forgot-password');

    Route::post('/user/reset-password-token', [NewPasswordController::class, 'store'])
        ->name('reset-password');

    Route::middleware('auth:api')->group(function () {
        Route::get('/user/logout', [LoggedinUserController::class, 'destroy'])->name('logout');

        Route::singleton('user', UserController::class)->destroyable();
        Route::get('/user/orders', [UserOrderController::class, 'index'])->name('user.orders');

        Route::apiResource('category', CategoryController::class)->only('update', 'destroy');
        Route::post('/category/create', [CategoryController::class, 'store'])->name('categories.store');

        Route::apiResource('brand', BrandController::class)->only('update', 'destroy');
        Route::post('/brand/create', [BrandController::class, 'store'])->name('brands.store');

        Route::resource('product', ProductController::class)->only('update', 'destroy');
        Route::post('/products/create', [ProductController::class, 'store'])->name('products.store');

        Route::resource('order-status', OrderStatusController::class)->only('update', 'destroy');
        Route::post('/order-statuses/create', [OrderStatusController::class, 'store'])->name('order-statuses.store');

        Route::apiResource('payment', PaymentController::class)->except('store', 'index');
        Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
        Route::post('/payments/create', [PaymentController::class, 'store'])->name('payments.store');

        Route::apiResource('order', OrderController::class)->except('store', 'index');
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::post('/orders/create', [OrderController::class, 'store'])->name('orders.store');
        Route::get('/orders/dashboard', [OrderController::class, 'index'])->name('orders.dashboard');
        Route::get('/orders/shipment-locator', [ShipmentLocatorController::class, 'index'])->name('orders.shipment-locator');
        Route::get('/order/{order}/download', DownloadInvoiceController::class)->name('order.download');
    });

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/category/{category}', [CategoryController::class, 'show'])->name('category.show');

    Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
    Route::get('/brand/{brand}', [BrandController::class, 'show'])->name('brand.show');

    Route::get('/products', [ProductController::class, 'index'])->name('products.show');
    Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');

    Route::get('/order-statuses', [OrderStatusController::class, 'index'])->name('order-statuses.index');
    Route::get('/order-status/{order_status}', [OrderStatusController::class, 'show'])->name('order-status.show');

    Route::resource('main/blog', PostController::class)->only(['index', 'show']);
    Route::get('/main/promotions', [PromotionController::class, 'index'])->name('promotions.index');
});
