<?php

use App\Http\Controllers\V1\Admin\RejectionController;
use App\Tbuy\User\Constants\Permission;
use Illuminate\Support\Facades\Route;

Route::prefix('rejection')
    ->name('rejection.')
    ->middleware('auth:sanctum')
    ->group(function () {

        Route::get('', [RejectionController::class, 'index'])
            ->middleware(Permission::VIEW_REJECTIONS->toString())
            ->name('index');

        Route::put('{rejection}', [RejectionController::class, 'update'])
            ->middleware(Permission::UPDATE_REJECTION->toString())
            ->name('update');
    });
