<?php

use App\Http\Controllers\Auth\LoggedinUserController;
use App\Http\Controllers\Auth\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/user/create', [RegistrationController::class, 'store'])->name('register');
    Route::post('/user/login', [LoggedinUserController::class, 'store'])->name('login');
});
