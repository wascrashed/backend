<?php

use App\Http\Controllers\V1\Admin\ReasonController;
use App\Tbuy\User\Constants\Permission;
use Illuminate\Support\Facades\Route;

Route::name('reason.')
    ->prefix('reason')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get('/', [ReasonController::class, 'index'])
            ->middleware(Permission::VIEW_REJECTIONS->toString())
            ->name('index');
    });
