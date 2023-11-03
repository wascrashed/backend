<?php

use Illuminate\Support\Facades\Route;
use App\Tbuy\User\Constants\Permission;
use App\Http\Controllers\V1\Admin\QuestionController;

Route::prefix('question')
    ->name('question.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get('/', [QuestionController::class, 'index'])
            ->name('index');

        Route::post('/', [QuestionController::class, 'store'])
            ->middleware(Permission::STORE_QUESTION->toString())
            ->name('store');

        Route::get('/{question}', [QuestionController::class, 'show'])
            ->whereNumber('question')
            ->name('show');

        Route::put('/{question}', [QuestionController::class, 'update'])
            ->middleware(Permission::UPDATE_QUESTION->toString())
            ->whereNumber('question')
            ->name('update');

        Route::delete('/{question}', [QuestionController::class, 'destroy'])
            ->middleware(Permission::DELETE_QUESTION->toString())
            ->whereNumber('question')
            ->name('destroy');
    });
