<?php


/** MENU ROUTES */

use App\Http\Controllers\V1\Admin\MenuController;
use App\Http\Controllers\V1\Admin\MenuUserPermissionController;
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


Route::prefix('menu')
    ->name('menu.')
    ->middleware(['auth:sanctum', Permission::VIEW_MENU->toString()])
    ->group(function() {
        Route::get('', [MenuController::class, 'index'])->name('index');

        Route::get('{menu}', [MenuController::class, 'show'])
            ->name('show')
            ->whereNumber('menu');

        Route::post('set-user', [MenuUserPermissionController::class, 'store'])
            ->middleware(Permission::MENU_SET_USER->toString())
            ->name('user.store');

        Route::post('', [MenuController::class, 'store'])
            ->middleware(Permission::CREATE_MENU->toString())
            ->name('store');

        Route::put('{menu}', [MenuController::class, 'update'])
            ->middleware(Permission::UPDATE_MENU->toString())
            ->name('update')
            ->whereNumber('menu');

        Route::delete('{menu}', [MenuController::class, 'destroy'])
            ->whereNumber('menu')
            ->middleware(Permission::DELETE_MENU->toString())
            ->name('delete');

    });

