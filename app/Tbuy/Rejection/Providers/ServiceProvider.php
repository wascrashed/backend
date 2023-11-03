<?php

namespace App\Tbuy\Rejection\Providers;

use App\Enums\MorphType;
use App\Tbuy\Rejection\Repository\RejectionRepository;
use App\Tbuy\Rejection\Repository\RejectionRepositoryImplementation;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(RejectionRepository::class, RejectionRepositoryImplementation::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Relation::morphMap(MorphType::morphMap());
    }
}
