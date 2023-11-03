<?php

namespace App\Tbuy\Invite\Providers;

use App\Tbuy\Invite\Repositories\InviteRepository;
use App\Tbuy\Invite\Repositories\InviteRepositoryImplementation;
use App\Tbuy\Invite\Services\InviteService;
use App\Tbuy\Invite\Services\InviteServiceImplementation;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(InviteRepository::class, InviteRepositoryImplementation::class);
        $this->app->bind(InviteService::class, InviteServiceImplementation::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
