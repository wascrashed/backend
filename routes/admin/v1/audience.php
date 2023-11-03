<?php

use App\Http\Controllers\V1\Admin\AudienceController;
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

Route::prefix('audience')
    ->name('audience.')
    ->middleware(['auth:sanctum', Permission::VIEW_AUDIENCE_LIST->toString()])
    ->group(function () {
        Route::get('', [AudienceController::class, 'index'])
            ->name('index');

        Route::post('', [AudienceController::class, 'store'])
            ->middleware(Permission::CREATE_AUDIENCE->toString())
            ->name('store');

        Route::get('{audience}', [AudienceController::class, 'show'])
            ->whereNumber('audience')
            ->name('show');

        Route::put('{audience}', [AudienceController::class, 'update'])
            ->middleware(Permission::UPDATE_AUDIENCE->toString())
            ->whereNumber('audience')
            ->name('update');

        Route::delete('{audience}', [AudienceController::class, 'destroy'])
            ->middleware(Permission::DELETE_AUDIENCE->toString())
            ->whereNumber('audience')
            ->name('destroy');
    });
