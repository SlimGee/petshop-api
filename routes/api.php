<?php

use App\Http\Controllers\Auth\LoggedinUserController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Auth\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/user/create', [RegistrationController::class, 'store'])->name('register');
    Route::post('/user/login', [LoggedinUserController::class, 'store'])->name('login');

    Route::middleware('auth:api')->group(function () {
        Route::get('/user/logout', [LoggedinUserController::class, 'destroy'])->name('logout');
        Route::singleton('user', UserController::class)->destroyable();
    });

});
