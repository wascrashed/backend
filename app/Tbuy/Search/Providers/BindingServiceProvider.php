<?php

namespace App\Tbuy\Search\Providers;

use App\Tbuy\Search\Repositories\SearchableFieldRepository;
use App\Tbuy\Search\Repositories\SearchableFieldRepositoryImplementation;
use App\Tbuy\Search\Repositories\SearchableModelRepository;
use App\Tbuy\Search\Repositories\SearchableModelRepositoryImplementation;
use App\Tbuy\Search\Services\SearchableFieldService;
use App\Tbuy\Search\Services\SearchableFieldServiceImplementation;
use App\Tbuy\Search\Services\SearchableModelService;
use App\Tbuy\Search\Services\SearchableModelServiceImplementation;
use Illuminate\Support\ServiceProvider;

class BindingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(SearchableFieldService::class, SearchableFieldServiceImplementation::class);
        $this->app->bind(SearchableModelService::class, SearchableModelServiceImplementation::class);
        $this->app->bind(SearchableFieldRepository::class, SearchableFieldRepositoryImplementation::class);
        $this->app->bind(SearchableModelRepository::class, SearchableModelRepositoryImplementation::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
