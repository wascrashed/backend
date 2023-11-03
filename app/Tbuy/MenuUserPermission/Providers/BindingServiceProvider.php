<?php

namespace App\Tbuy\MenuUserPermission\Providers;

use App\Tbuy\MenuUserPermission\Services\MenuUserService;
use App\Tbuy\MenuUserPermission\Services\MenuUserServiceImplementation;
use Illuminate\Support\ServiceProvider;

class BindingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(MenuUserService::class, MenuUserServiceImplementation::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
