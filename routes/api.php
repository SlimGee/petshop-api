<?php

use App\Http\Controllers\Auth\LoggedinUserController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetTokenController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Main\PostController;
use App\Http\Controllers\Main\PromotionController;
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

        Route::apiResource('categories', CategoryController::class)->only('update', 'destroy');
        Route::post('/categories/create', [CategoryController::class, 'store'])->name('categories.store');
    });

    Route::resource('categories', CategoryController::class)->only('show', 'index');
    Route::resource('main/blog', PostController::class)->only(['index', 'show']);
    Route::get('/main/promotions', [PromotionController::class, 'index'])->name('promotions.index');
});
