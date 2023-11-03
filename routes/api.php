<?php

use App\Http\Controllers\V1\CountryController;
use Illuminate\Support\Facades\Route;

Route::get('country', CountryController::class)->name('country');

Route::get('/search', [\App\Http\Controllers\V1\Client\SearchController::class, 'index']);
