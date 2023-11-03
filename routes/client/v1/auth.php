<?php

use App\Http\Controllers\V1\Client\AuthController;
use App\Http\Controllers\V1\Admin\AuthController as AdminAuthUser;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::get('auth/user', [AdminAuthUser::class, 'getAuthUser'])->name('auth.user');

    Route::post('change-password', [AuthController::class, 'changePassword'])
        ->name('auth.changePassword');

    Route::get('auth/company', [AuthController::class, 'getAuthCompany'])
        ->name('auth.getAuthCompany');
});

Route::middleware('guest:sanctum')->group(function () {

    Route::post('login', [AuthController::class, 'login'])->name('auth.login');

    Route::post('forgot-password', [AuthController::class, 'forgotPassword'])
        ->name('auth.forgotPassword');
});
