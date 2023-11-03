<?php

use App\Http\Controllers\V1\Client\EmployeeController;
use App\Tbuy\User\Constants\Permission;
use Illuminate\Support\Facades\Route;

Route::prefix('employee')
    ->name('employee')
    ->group(function () {

        Route::middleware(['auth:sanctum', Permission::ViEW_COMPANY_EMPLOYEE->toString()])
            ->group(function () {
                Route::get('', [EmployeeController::class, 'index'])
                    ->name('index');

                Route::post('', [EmployeeController::class, 'store'])
                    ->middleware(Permission::STORE_COMPANY_EMPLOYEE->toString())
                    ->name('store');

                Route::get('{employee}', [EmployeeController::class, 'show'])
                    ->middleware(Permission::SHOW_COMPANY_EMPLOYEE->toString())
                    ->whereNumber('employee')
                    ->name('show');

                Route::put('{employee}', [EmployeeController::class, 'update'])
                    ->middleware(Permission::UPDATE_COMPANY_EMPLOYEE->toString())
                    ->whereNumber('employee')
                    ->name('update');

                Route::delete('{employee}', [EmployeeController::class, 'delete'])
                    ->middleware(Permission::DELETE_COMPANY_EMPLOYEE->toString())
                    ->whereNumber('employee')
                    ->name('delete');
            });

        Route::middleware(['guest:sanctum'])
            ->group(function () {
                Route::post('login', [EmployeeController::class, 'login'])
                    ->name('login');
            });
    });

