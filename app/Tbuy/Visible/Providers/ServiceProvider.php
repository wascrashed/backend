<?php

namespace App\Tbuy\Visible\Providers;

use App\Tbuy\Visible\Repositories\VisibleRepository;
use App\Tbuy\Visible\Repositories\VisibleRepositoryImplementation;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(VisibleRepository::class, VisibleRepositoryImplementation::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
