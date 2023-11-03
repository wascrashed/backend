<?php

namespace App\Tbuy\AttributeValue\Providers;

use App\Tbuy\AttributeValue\Repositories\AttributeValueRepository;
use App\Tbuy\AttributeValue\Repositories\AttributeValueRepositoryImplementation;
use App\Tbuy\AttributeValue\Services\AttributeValueService;
use App\Tbuy\AttributeValue\Services\AttributeValueServiceImplementation;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(AttributeValueRepository::class, AttributeValueRepositoryImplementation::class);
        $this->app->bind(AttributeValueService::class, AttributeValueServiceImplementation::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
