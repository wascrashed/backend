<?php

namespace App\Tbuy\Templates\Providers;

use App\Tbuy\Templates\Repositories\TemplatesRepository;
use App\Tbuy\Templates\Repositories\TemplatesRepositoryImplementation;
use App\Tbuy\Templates\Services\TemplatesService;
use App\Tbuy\Templates\Services\TemplatesServiceImplementation;
use Illuminate\Support\ServiceProvider;

class BindingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(TemplatesRepository::class, TemplatesRepositoryImplementation::class);
        $this->app->bind(TemplatesService::class, TemplatesServiceImplementation::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
