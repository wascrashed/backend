<?php


use App\Http\Controllers\V1\Admin\TemplatesController;
use App\Tbuy\User\Constants\Permission;
use Illuminate\Support\Facades\Route;

Route::prefix('templates')
    ->name('templates.')
    ->middleware(['auth:sanctum', Permission::VIEW_BANNER->toString()])
    ->group(function () {
        Route::get('', [TemplatesController::class, 'index'])->name('index');
        Route::get('{templates}', [TemplatesController::class, 'show'])
            ->whereNumber('templates')
            ->name('show');
        Route::post('', [TemplatesController::class, 'store'])
            ->name('store')
            ->middleware(Permission::CREATE_BANNER->toString());
        Route::put('{templates}', [TemplatesController::class, 'update'])
            ->name('update')
            ->whereNumber('templates')
            ->middleware(Permission::UPDATE_BANNER->toString());
        Route::delete('{templates}', [TemplatesController::class, 'destroy'])
            ->name('delete')
            ->whereNumber('templates')
            ->middleware(Permission::DELETE_BANNER->toString());
    });
