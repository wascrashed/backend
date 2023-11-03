<?php

namespace App\Tbuy\Tariff\Providers;

use App\Tbuy\Tariff\Models\Tariff;
use App\Tbuy\Tariff\Observers\TariffObserver;
use App\Tbuy\Tariff\Repositories\TariffLogRepository;
use App\Tbuy\Tariff\Repositories\TariffLogRepositoryImplementation;
use App\Tbuy\Tariff\Repositories\TariffPrivilegeRepository;
use App\Tbuy\Tariff\Repositories\TariffPrivilegeRepositoryImplementation;
use App\Tbuy\Tariff\Repositories\TariffRepository;
use App\Tbuy\Tariff\Repositories\TariffRepositoryImplementation;
use App\Tbuy\Tariff\Services\TariffLogService;
use App\Tbuy\Tariff\Services\TariffLogServiceImplementation;
use App\Tbuy\Tariff\Services\TariffService;
use App\Tbuy\Tariff\Services\TariffServiceImplementation;
use Illuminate\Support\ServiceProvider;

class BindingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(TariffRepository::class, TariffRepositoryImplementation::class);
        $this->app->bind(TariffService::class, TariffServiceImplementation::class);

        $this->app->bind(TariffPrivilegeRepository::class, TariffPrivilegeRepositoryImplementation::class);
        $this->app->bind(TariffLogRepository::class, TariffLogRepositoryImplementation::class);
        $this->app->bind(TariffLogService::class, TariffLogServiceImplementation::class);
    }

    public function boot(): void
    {
        Tariff::observe(TariffObserver::class);
    }
}
