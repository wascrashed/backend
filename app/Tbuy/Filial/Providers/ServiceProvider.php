<?php

namespace App\Tbuy\Filial\Providers;

use App\Tbuy\Filial\Repositories\FilialRepository;
use App\Tbuy\Filial\Repositories\FilialRepositoryImplementation;
use App\Tbuy\Filial\Services\FilialService;
use App\Tbuy\Filial\Services\FilialServiceImplementation;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(FilialRepository::class, FilialRepositoryImplementation::class);
        $this->app->bind(FilialService::class, FilialServiceImplementation::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
