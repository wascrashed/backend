<?php

use App\Http\Controllers\V1\Admin\SearchableFieldController;
use App\Http\Controllers\V1\Admin\SearchableModelController;
use App\Tbuy\User\Constants\Permission;
use Illuminate\Support\Facades\Route;

/** SEARCHABLE FIELD ROUTES */

Route::middleware(['auth:sanctum'])
    ->name('search_field.')
    ->prefix('search-field')
    ->group(function () {
        Route::get('', [SearchableFieldController::class, 'index'])
            ->middleware(Permission::VIEW_SEARCHABLE_FIELD->toString())
            ->name('index');
        Route::post('', [SearchableFieldController::class, 'store'])
            ->middleware(Permission::STORE_SEARCHABLE_FIELD->toString())
            ->name('store');
        Route::get('{searchableField}', [SearchableFieldController::class, 'show'])
            ->middleware(Permission::SHOW_SEARCHABLE_FIELD->toString())
            ->name('show');
        Route::put('{searchableField}', [SearchableFieldController::class, 'update'])
            ->middleware(Permission::UPDATE_SEARCHABLE_FIELD->toString())
            ->name('update');
        Route::delete('{searchableField}', [SearchableFieldController::class, 'destroy'])
            ->middleware(Permission::DELETE_SEARCHABLE_FIELD->toString())
            ->name('destroy');
    });

/** SEARCHABLE MODEL ROUTES */

Route::middleware(['auth:sanctum'])
    ->name('search_model.')
    ->prefix('search-model')
    ->group(function () {
        Route::get('', [SearchableModelController::class, 'index'])
            ->middleware(Permission::VIEW_SEARCHABLE_MODEL->toString())
            ->name('index');
        Route::post('', [SearchableModelController::class, 'store'])
            ->middleware(Permission::STORE_SEARCHABLE_MODEL->toString())
            ->name('store');
        Route::get('{searchableModel}', [SearchableModelController::class, 'show'])
            ->middleware(Permission::SHOW_SEARCHABLE_MODEL->toString())
            ->name('show');
        Route::put('{searchableModel}', [SearchableModelController::class, 'update'])
            ->middleware(Permission::UPDATE_SEARCHABLE_MODEL->toString())
            ->name('update');
        Route::delete('{searchableModel}', [SearchableModelController::class, 'destroy'])
            ->middleware(Permission::DELETE_SEARCHABLE_MODEL->toString())
            ->name('destroy');
    });

