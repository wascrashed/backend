<?php

namespace App\Tbuy\Audience\Providers;

use App\Tbuy\Audience\Repositories\AudienceRepository;
use App\Tbuy\Audience\Repositories\AudienceRepositoryImplementation;
use App\Tbuy\Audience\Services\AudienceService;
use App\Tbuy\Audience\Services\AudienceServiceImplementation;
use Illuminate\Support\ServiceProvider;

class BindingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AudienceRepository::class, AudienceRepositoryImplementation::class);
        $this->app->bind(AudienceService::class, AudienceServiceImplementation::class);
    }

    public function boot(): void
    {
    }
}
