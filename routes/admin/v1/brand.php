<?php

use App\Http\Controllers\V1\Admin\BrandCategoryController;
use App\Http\Controllers\V1\Admin\BrandController;
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

Route::prefix('brand')
    ->middleware('auth:sanctum')
    ->name('brand.')->group(function () {
        Route::get('', [BrandController::class, 'index'])
            ->middleware(Permission::VIEW_BRAND->toString())
            ->name('index');

        Route::get('{brand}', [BrandController::class, 'show'])
            ->middleware(Permission::VIEW_BRAND->toString())
            ->whereNumber('brand')
            ->name('show');

        Route::post('', [BrandController::class, 'store'])
            ->middleware(Permission::CREATE_BRAND->toString())
            ->name('store');

        Route::post('{brand}/attach-product', [BrandController::class, 'attach'])
            ->middleware(Permission::BRAND_ATTACH_PRODUCT->toString())
            ->whereNumber('brand')
            ->name('attach_product');

        Route::put('{brand}', [BrandController::class, 'update'])
            ->middleware(Permission::UPDATE_BRAND->toString())
            ->whereNumber('brand')
            ->name('update');

        Route::patch('{brand}/set-status', [BrandController::class, 'setStatus'])
            ->whereNumber('brand')
            ->middleware(Permission::BRAND_STATUS_EDIT->toString())
            ->name('set_status');

        Route::delete('{brand}', [BrandController::class, 'destroy'])
            ->middleware(Permission::DELETE_BRAND->toString())
            ->whereNumber('brand')
            ->name('destroy');

        Route::patch('{brand}', [BrandController::class, 'setAttribute'])
            ->middleware(Permission::SET_BRAND_ATTRIBUTE->toString())
            ->whereNumber('brand')
            ->name('set_attribute');

        Route::patch('{brand}/extend-name', [BrandController::class, 'extendName'])
            ->middleware(Permission::SET_BRAND_ATTRIBUTE->toString())
            ->whereNumber('brand')
            ->name('extend_name');

        Route::post('{brand}/set-category', [BrandCategoryController::class, 'store'])
            ->middleware(Permission::BRAND_ATTACH_CATEGORY->toString())
            ->whereNumber('brand')
            ->name('set_category');
    });
