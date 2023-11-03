<?php

namespace App\Tbuy\Settings\Providers;

use App\Tbuy\Settings\Repositories\SettingsRepository;
use App\Tbuy\Settings\Repositories\SettingsRepositoryImplementation;
use App\Tbuy\Settings\Services\SettingsService;
use App\Tbuy\Settings\Services\SettingsServiceImplementation;
use Illuminate\Support\ServiceProvider;

class BindingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(SettingsService::class, SettingsServiceImplementation::class);
        $this->app->bind(SettingsRepository::class, SettingsRepositoryImplementation::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
