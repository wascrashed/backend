<?php


use App\Http\Controllers\V1\Admin\SettingsController;
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

Route::prefix('settings')
    ->name('settings.')
 ->middleware(['auth:sanctum', Permission::VIEW_SETTINGS->toString()])
    ->group(function () {
        Route::get('', [SettingsController::class, 'index'])->name('list');

        Route::get('{settings}', [SettingsController::class, 'show'])
            ->middleware(Permission::SHOW_SETTINGS->toString())
             ->whereNumber('settings')
             ->name('show');

         Route::put('{settings}', [SettingsController::class, 'update'])
            ->middleware(Permission::UPDATE_SETTINGS->toString())
             ->whereNumber('settings')
             ->name('update');
    });
