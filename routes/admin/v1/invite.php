<?php

use App\Http\Controllers\V1\Admin\InviteController;
use App\Tbuy\User\Constants\Permission;
use Illuminate\Support\Facades\Route;

Route::prefix('invite')
    ->name('invite.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::post('', [InviteController::class, 'store'])
            ->name('store')
            ->middleware(Permission::INVITE_CREATE->toString());

        Route::patch('', [InviteController::class, 'activate'])
            ->name('activate')
            ->middleware(Permission::INVITE_ACTIVATE->toString());
    });
