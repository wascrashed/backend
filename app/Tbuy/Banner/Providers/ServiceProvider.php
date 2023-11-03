<?php

namespace App\Tbuy\Banner\Providers;

use App\Tbuy\Banner\Repositories\BannerRepository;
use App\Tbuy\Banner\Repositories\BannerRepositoryImplementation;
use App\Tbuy\Banner\Services\BannerService;
use App\Tbuy\Banner\Services\BannerServiceImplementation;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(BannerRepository::class, BannerRepositoryImplementation::class);
        $this->app->bind(BannerService::class, BannerServiceImplementation::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
