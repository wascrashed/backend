<?php

use App\Http\Controllers\V1\Admin\TargetController;
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

Route::prefix('target')
    ->name('target.')
    ->middleware(['auth:sanctum', Permission::VIEW_TARGET_LIST->toString()])
    ->group(function () {
        Route::get('', [TargetController::class, 'index'])
            ->name('index');

        Route::post('', [TargetController::class, 'store'])
            ->middleware(Permission::CREATE_TARGET->toString())
            ->name('store');

        Route::get('{target}', [TargetController::class, 'show'])
            ->whereNumber('target')
            ->name('show');

        Route::put('{target}', [TargetController::class, 'update'])
            ->middleware(Permission::UPDATE_TARGET->toString())
            ->whereNumber('target')
            ->name('update');

        Route::delete('{target}', [TargetController::class, 'destroy'])
            ->middleware(Permission::DELETE_TARGET->toString())
            ->whereNumber('target')
            ->name('destroy');

        Route::post('{target}/change-status', [TargetController::class, 'changeStatus'])
            ->middleware(Permission::CHANGE_TARGET_STATUS->toString())
            ->whereNumber('target')
            ->name('change-status');

        Route::get('{target}/views/increment', [TargetController::class, 'incrementViews'])
            ->whereNumber('target')
            ->name('increment-views');
    });
