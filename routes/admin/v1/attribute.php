<?php

use App\Http\Controllers\V1\Admin\AttributeController;
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

Route::prefix('attribute')
    ->name('attribute.')
    ->middleware(['auth:sanctum', Permission::VIEW_ATTRIBUTE->toString()])
    ->group(function () {
        Route::get('', [AttributeController::class, 'index'])
            ->name('index');

        Route::post('', [AttributeController::class, 'store'])
            ->middleware(Permission::CREATE_ATTRIBUTE->toString())
            ->name('store');

        Route::put('{attribute}', [AttributeController::class, 'update'])
            ->middleware(Permission::UPDATE_ATTRIBUTE->toString())
            ->name('update')
            ->whereNumber('attribute');

        Route::delete('{attribute}', [AttributeController::class, 'destroy'])
            ->middleware(Permission::DELETE_ATTRIBUTE->toString())
            ->name('destroy')
            ->whereNumber('attribute');
    });
