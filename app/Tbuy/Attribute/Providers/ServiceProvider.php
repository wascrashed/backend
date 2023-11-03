<?php

namespace App\Tbuy\Attribute\Providers;

use App\Tbuy\Attribute\Models\Attribute;
use App\Tbuy\Attribute\Observers\AttributeObserver;
use App\Tbuy\Attribute\Repositories\AttributeRepository;
use App\Tbuy\Attribute\Repositories\AttributeRepositoryImplementation;
use App\Tbuy\Attribute\Services\AttributeService;
use App\Tbuy\Attribute\Services\AttributeServiceImplementation;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(AttributeRepository::class, AttributeRepositoryImplementation::class);
        $this->app->bind(AttributeService::class, AttributeServiceImplementation::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Attribute::observe(AttributeObserver::class);
    }
}
