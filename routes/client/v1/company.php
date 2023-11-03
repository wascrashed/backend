<?php

use App\Http\Controllers\V1\Admin\AuthController;
use App\Http\Controllers\V1\Admin\CompanyController as AdminCompanyController;
use App\Http\Controllers\V1\Client\CompanyController;
use App\Http\Controllers\V1\Client\FilialController;
use App\Tbuy\User\Constants\Permission;
use Illuminate\Support\Facades\Route;

Route::prefix('company')
    ->name('company.')
    ->group(function () {

        Route::post('register', [CompanyController::class, 'store'])
            ->name('register');

        Route::middleware(['auth:sanctum', Permission::VIEW_COMPANY->toString()])->group(function () {
            Route::get('{company}/subscribe', [CompanyController::class, 'subscribe'])
                ->middleware(Permission::SUBSCRIBE_COMPANY->toString())
                ->whereNumber('company')
                ->name('subscribe');

            Route::get('{company}/unsubscribe', [CompanyController::class, 'unsubscribe'])
                ->middleware(Permission::UNSUBSCRIBE_COMPANY->toString())
                ->whereNumber('company')
                ->name('unsubscribe');

            Route::get('{company}', [AdminCompanyController::class, 'show'])
                ->name('show')
                ->whereNumber('company');

            Route::put('{company}', [AdminCompanyController::class, 'update'])
                ->middleware(Permission::UPDATE_COMPANY->toString())
                ->whereNumber('company')
                ->name('update');

            Route::patch('{company}/score', [CompanyController::class, 'score'])
                ->middleware(Permission::SCORE_COMPANY->toString())
                ->whereNumber('company')
                ->name('score');

            Route::post('{company}/data-confirmation', [CompanyController::class, 'dataConfirmation'])
                ->middleware(Permission::DATA_CONFIRMATION->toString())
                ->whereNumber('company')
                ->name('data-confirmation');

            Route::prefix('{company}/filial')
                ->name('filial.')
                ->middleware(Permission::VIEW_COMPANY_FILIAL->toString())
                ->whereNumber('company')
                ->group(function () {
                    Route::get('', [FilialController::class, 'index'])->name('index');

                    Route::post('', [FilialController::class, 'store'])
                        ->middleware(Permission::CREATE_COMPANY_FILIAL->toString())
                        ->name('store');

                    Route::put('{filial}', [FilialController::class, 'update'])
                        ->middleware(Permission::UPDATE_COMPANY_FILIAL->toString())
                        ->whereNumber('filial')
                        ->name('update');

                    Route::delete('{filial}', [FilialController::class, 'destroy'])
                        ->middleware(Permission::DELETE_COMPANY_FILIAL->toString())
                        ->whereNumber('filial')
                        ->name('destroy');
                });
        });
    });
