<?php

use App\Http\Controllers\V1\Client\BrandController;
use App\Tbuy\User\Constants\Permission;
use Illuminate\Support\Facades\Route;

Route::prefix('brand')
    ->name('brand.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get('{brand}/subscribe', [BrandController::class, 'subscribe'])
            ->middleware(Permission::SUBSCRIBE_BRAND->toString())
            ->whereNumber('brand')
            ->name('subscribe');

        Route::get('{brand}/unsubscribe', [BrandController::class, 'unsubscribe'])
            ->middleware(Permission::UNSUBSCRIBE_BRAND->toString())
            ->whereNumber('brand')
            ->name('unsubscribe');
    });
