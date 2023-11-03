<?php

use App\Http\Controllers\V1\Admin\LocaleController;
use App\Tbuy\User\Constants\Permission;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('locale')
    ->name('locale.')
    ->middleware(['auth:sanctum', Permission::VIEW_LOCALE->toString()])
    ->group(function () {
        Route::get('', [LocaleController::class, 'index'])
            ->name('index');

        Route::post('', [LocaleController::class, 'store'])
            ->middleware(Permission::CREATE_LOCALE->toString())
            ->name('store');

        Route::get('{locale}', [LocaleController::class, 'show'])
            ->whereNumber('locale')
            ->name('show');

        Route::put('{locale}', [LocaleController::class, 'update'])
            ->middleware(Permission::UPDATE_LOCALE->toString())
            ->whereNumber('locale')
            ->name('update');
    });
