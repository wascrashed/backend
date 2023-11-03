<?php

use App\Http\Controllers\V1\Admin\TariffController;
use App\Http\Controllers\V1\Admin\TariffLogController;
use App\Tbuy\User\Constants\Permission;
use Illuminate\Support\Facades\Route;

Route::prefix('tariff')
    ->name('tariff.')
    ->middleware(['auth:sanctum', Permission::VIEW_TARIFF_LIST->toString()])
    ->group(function () {
        Route::get('', [TariffController::class, 'index'])
            ->name('index');

        Route::get('log', [TariffLogController::class, 'index'])
            ->middleware(Permission::VIEW_TARIFF_LOG->toString())
            ->name('log');

        Route::post('', [TariffController::class, 'store'])
            ->middleware(Permission::CREATE_TARIFF->toString())
            ->name('store');

        Route::get('{tariff}', [TariffController::class, 'show'])
            ->whereNumber('tariff')
            ->name('show');

        Route::put('{tariff}', [TariffController::class, 'update'])
            ->middleware(Permission::UPDATE_TARIFF->toString())
            ->whereNumber('tariff')
            ->name('update');

        Route::delete('{tariff}', [TariffController::class, 'destroy'])
            ->middleware(Permission::DELETE_TARIFF->toString())
            ->whereNumber('tariff')
            ->name('destroy');
    });
