<?php

use App\Http\Controllers\Auth\LoggedinUserController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetTokenController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Main\PostController;
use App\Http\Controllers\Main\PromotionController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderStatusController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
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

        Route::apiResource('categories', CategoryController::class)->only('update', 'destroy');
        Route::post('/category/create', [CategoryController::class, 'store'])->name('categories.store');

        Route::apiResource('brands', BrandController::class)->only('update', 'destroy');
        Route::post('/brand/create', [BrandController::class, 'store'])->name('brands.store');

        Route::resource('products', ProductController::class)->only('update', 'destroy');
        Route::post('/products/create', [ProductController::class, 'store'])->name('products.store');

        Route::resource('order-statuses', OrderStatusController::class)->only('update', 'destroy');
        Route::post('/order-statuses/create', [OrderStatusController::class, 'store'])->name('order-statuses.store');

        Route::apiResource('payments', PaymentController::class)->except('store');
        Route::post('/payments/create', [PaymentController::class, 'store'])->name('payments.store');

        Route::apiResource('orders', OrderController::class)->except('store');
        Route::post('/orders/create', [OrderController::class, 'store'])->name('orders.store');
    });

    Route::resource('categories', CategoryController::class)->only('show', 'index');
    Route::resource('brands', BrandController::class)->only('show', 'index');
    Route::resource('products', ProductController::class)->only('show', 'index');
    Route::resource('order-statuses', OrderStatusController::class)->only('show', 'index');

    Route::resource('main/blog', PostController::class)->only(['index', 'show']);
    Route::get('/main/promotions', [PromotionController::class, 'index'])->name('promotions.index');
});
