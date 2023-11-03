<?php

use App\Http\Controllers\V1\Client\TariffController;
use App\Tbuy\User\Constants\Permission;
use Illuminate\Support\Facades\Route;

Route::prefix('tariff')
    ->name('tariff.')
    ->middleware(['auth:sanctum', Permission::VIEW_TARIFF_LIST->toString()])
    ->group(function () {
        Route::get('', [TariffController::class, 'index'])
            ->name('index');

        Route::post('{tariff}/buy', [TariffController::class, 'buy'])
            ->middleware(Permission::BUY_TARIFF->toString())
            ->whereNumber('tariff')
            ->name('buy');
    });
