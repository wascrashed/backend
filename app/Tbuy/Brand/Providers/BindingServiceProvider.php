<?php

namespace App\Tbuy\Brand\Providers;

use App\Tbuy\Brand\Repositories\BrandRepository;
use App\Tbuy\Brand\Repositories\BrandRepositoryImplementation;
use App\Tbuy\Brand\Repositories\Reason\ReasonRepository;
use App\Tbuy\Brand\Repositories\Reason\ReasonRepositoryImplementation;
use App\Tbuy\Brand\Repositories\Rejection\RejectionRepository;
use App\Tbuy\Brand\Repositories\Rejection\RejectionRepositoryImplementation;
use App\Tbuy\Brand\Services\BrandService;
use App\Tbuy\Brand\Services\BrandServiceImplementation;
use App\Tbuy\Reason\Repositories\ReasonService;
use App\Tbuy\Reason\Repositories\ReasonServiceImplementation;
use App\Tbuy\Rejection\Services\RejectionService;
use App\Tbuy\Rejection\Services\RejectionServiceImplementation;
use Illuminate\Support\ServiceProvider;

class BindingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(BrandRepository::class, BrandRepositoryImplementation::class);
        $this->app->bind(RejectionRepository::class, RejectionRepositoryImplementation::class);
        $this->app->bind(ReasonRepository::class, ReasonRepositoryImplementation::class);
        $this->app->bind(BrandService::class, BrandServiceImplementation::class);
        $this->app->bind(RejectionService::class, RejectionServiceImplementation::class);
        $this->app->bind(ReasonService::class, ReasonServiceImplementation::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
