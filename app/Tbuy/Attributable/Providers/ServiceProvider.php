<?php

namespace App\Tbuy\Attributable\Providers;

use App\Tbuy\Attributable\Models\Attributable;
use App\Tbuy\Attributable\Observers\AttributableObserver;
use App\Tbuy\Attributable\Repositories\AttributableRepository;
use App\Tbuy\Attributable\Repositories\AttributableRepositoryImplementation;
use App\Tbuy\Attributable\Services\AttributableService;
use App\Tbuy\Attributable\Services\AttributableServiceImplementation;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(AttributableRepository::class, AttributableRepositoryImplementation::class);
        $this->app->bind(AttributableService::class, AttributableServiceImplementation::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Attributable::observe(AttributableObserver::class);
    }
}
