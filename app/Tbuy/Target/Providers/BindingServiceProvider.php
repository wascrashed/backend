<?php

namespace App\Tbuy\Target\Providers;

use App\Tbuy\Target\Repositories\TargetRepository;
use App\Tbuy\Target\Repositories\TargetRepositoryImplementation;
use App\Tbuy\Target\Services\TargetService;
use App\Tbuy\Target\Services\TargetServiceImplementation;
use Illuminate\Support\ServiceProvider;

class BindingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(TargetRepository::class, TargetRepositoryImplementation::class);
        $this->app->bind(TargetService::class, TargetServiceImplementation::class);
    }

    public function boot(): void
    {
    }
}
