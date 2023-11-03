<?php

namespace App\Tbuy\Locale\Providers;

use App\Tbuy\Locale\Repositories\LocaleRepository;
use App\Tbuy\Locale\Repositories\LocaleRepositoryImplementation;
use App\Tbuy\Locale\Services\LocaleService;
use App\Tbuy\Locale\Services\LocaleServiceImplementation;
use Illuminate\Support\ServiceProvider;

class BindingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(LocaleRepository::class, LocaleRepositoryImplementation::class);
        $this->app->bind(LocaleService::class, LocaleServiceImplementation::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
