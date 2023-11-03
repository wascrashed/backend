<?php

namespace App\Tbuy\Promotion\Providers;

use App\Tbuy\Promotion\Repositories\PromotionRepository;
use App\Tbuy\Promotion\Repositories\PromotionRepositoryImplementation;
use App\Tbuy\Promotion\Services\PromotionService;
use App\Tbuy\Promotion\Services\PromotionServiceImplementation;
use Illuminate\Support\ServiceProvider;

class BindingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(PromotionService::class, PromotionServiceImplementation::class);
        $this->app->bind(PromotionRepository::class, PromotionRepositoryImplementation::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
