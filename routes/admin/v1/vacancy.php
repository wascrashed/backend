<?php

use App\Http\Controllers\V1\Admin\VacancyCategoryController;
use App\Http\Controllers\V1\Admin\VacancyController;
use App\Tbuy\User\Constants\Permission;
use Illuminate\Support\Facades\Route;

Route::prefix('vacancies')
    ->name('vacancies.')
    ->middleware(['auth:sanctum'])
    ->group(function () {
        Route::middleware([Permission::VIEW_VACANCY_LIST->toString()])
            ->group(function () {
                Route::get('', [VacancyController::class, 'index'])
                    ->name('index');

                Route::post('', [VacancyController::class, 'store'])
                    ->middleware(Permission::CREATE_VACANCY->toString())
                    ->name('store');

                Route::get('{vacancy}', [VacancyController::class, 'show'])
                    ->whereNumber('vacancy')
                    ->name('show');

                Route::put('{product}', [VacancyController::class, 'update'])
                    ->middleware(Permission::UPDATE_VACANCY->toString())
                    ->whereNumber('vacancy')
                    ->name('update');

                Route::delete('{product}', [VacancyController::class, 'destroy'])
                    ->middleware(Permission::DELETE_VACANCY->toString())
                    ->whereNumber('vacancy')
                    ->name('destroy');
            });

        Route::prefix('categories')
            ->name('categories.')
            ->middleware([Permission::VIEW_VACANCY_CATEGORY_LIST->toString()])
            ->group(function() {
                Route::get('', [VacancyCategoryController::class, 'index'])
                    ->name('index');

                Route::post('', [VacancyCategoryController::class, 'store'])
                    ->middleware(Permission::CREATE_VACANCY_CATEGORY->toString())
                    ->name('store');

                Route::get('{category}', [VacancyCategoryController::class, 'show'])
                    ->whereNumber('category')
                    ->name('show');

                Route::put('{category}', [VacancyCategoryController::class, 'update'])
                    ->middleware(Permission::UPDATE_VACANCY_CATEGORY->toString())
                    ->whereNumber('category')
                    ->name('update');

                Route::delete('{category}', [VacancyCategoryController::class, 'destroy'])
                    ->middleware(Permission::DELETE_VACANCY_CATEGORY->toString())
                    ->whereNumber('category')
                    ->name('destroy');
            });
    });
