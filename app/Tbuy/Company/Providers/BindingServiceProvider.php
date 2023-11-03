<?php

namespace App\Tbuy\Company\Providers;

use App\Tbuy\Company\Models\Company;
use App\Tbuy\Company\Observers\CompanyObserver;
use App\Tbuy\Company\Repositories\CompanyRepository;
use App\Tbuy\Company\Repositories\CompanyRepositoryImplementation;
use App\Tbuy\Company\Services\CompanyService;
use App\Tbuy\Company\Services\CompanyServiceImplementation;
use Illuminate\Support\ServiceProvider;

class BindingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CompanyService::class, CompanyServiceImplementation::class);
        $this->app->bind(CompanyRepository::class, CompanyRepositoryImplementation::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Company::observe(CompanyObserver::class);
    }
}
