<?php

use App\Http\Controllers\V1\Admin\CompanyController;
use App\Tbuy\User\Constants\Permission;
use Illuminate\Support\Facades\Route;

/** COMPANY ROUTES */

Route::middleware(['auth:sanctum'])
    ->name('company.')
    ->prefix('company')
    ->group(function () {
        Route::get('', [CompanyController::class, 'index'])
            ->middleware(Permission::VIEW_COMPANY->toString())
            ->name('index');

        Route::post('', [CompanyController::class, 'store'])
            ->middleware(Permission::STORE_COMPANY->toString())
            ->name('store');

        Route::get('{company}', [CompanyController::class, 'show'])
            ->middleware(Permission::SHOW_COMPANY->toString())
            ->whereNumber('company')
            ->name('show');

        Route::put('{company}', [CompanyController::class, 'update'])
            ->middleware(Permission::UPDATE_COMPANY->toString())
            ->whereNumber('company')
            ->name('update');

        Route::delete('{company}', [CompanyController::class, 'destroy'])
            ->middleware(Permission::DELETE_COMPANY->toString())
            ->whereNumber('company')
            ->name('destroy');

        Route::patch('{company}/toggle-status', [CompanyController::class,'toggleStatus'])
            ->middleware(Permission::TOGGLE_STATUS_COMPANY->toString())
            ->whereNumber('company')
            ->name('toggle_status');

        Route::get('{company}/employees', [CompanyController::class, 'getEmployees'])
            ->middleware(Permission::VIEW_COMPANY_EMPLOYEES->toString())
            ->whereNumber('company')
            ->name('employees');
    });
