<?php

use App\Http\Controllers\V1\Admin\UserController;
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

Route::middleware(['auth:sanctum'])->name('user.')->group(function () {
    Route::get('/user', [UserController::class, 'index'])
        ->middleware(Permission::VIEW_USER->toString())
        ->name('index');
    Route::post('/user', [UserController::class, 'store'])
        ->middleware(Permission::STORE_USER->toString())
        ->name('store');
    ;
    Route::get('/user/{user}', [UserController::class, 'show'])
        ->middleware(Permission::SHOW_USER->toString())
        ->name('show');
    ;
    Route::put('/user/{user}', [UserController::class, 'update'])
        ->middleware(Permission::UPDATE_USER->toString())
        ->name('update');
    ;
        Route::delete('/user/{user}', [UserController::class, 'destroy'])
        ->middleware(Permission::DELETE_USER->toString())
        ->name('destroy');
    ;
});
