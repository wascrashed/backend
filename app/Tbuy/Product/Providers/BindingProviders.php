<?php

namespace App\Tbuy\Product\Providers;

use App\Tbuy\Product\Models\Product;
use App\Tbuy\Product\Observers\ProductObserver;
use App\Tbuy\Product\Repositories\ProductRepository;
use App\Tbuy\Product\Repositories\ProductRepositoryImplementation;
use App\Tbuy\Product\Repositories\RejectedProductRepositoryImplementation;
use App\Tbuy\Product\Services\ProductService;
use App\Tbuy\Product\Services\ProductServiceImplementation;
use App\Tbuy\Product\Services\RejectedProductServiceImplementation;
use Illuminate\Support\ServiceProvider;

class BindingProviders extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ProductService::class, ProductServiceImplementation::class);
        $this->app->bind(ProductRepository::class, ProductRepositoryImplementation::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Product::observe(ProductObserver::class);
    }
}
