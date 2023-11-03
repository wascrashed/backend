<?php

namespace App\Tbuy\Menu\Providers;

use App\Tbuy\Menu\Models\Menu;
use App\Tbuy\Menu\Observers\MenuObserver;
use App\Tbuy\Menu\Repositories\MenuRepository;
use App\Tbuy\Menu\Repositories\MenuRepositoryImplementation;
use App\Tbuy\Menu\Services\MenuService;
use App\Tbuy\Menu\Services\MenuServiceImplementation;
use Illuminate\Support\ServiceProvider;

class BindingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(MenuRepository::class, MenuRepositoryImplementation::class);
        $this->app->bind(MenuService::class, MenuServiceImplementation::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Menu::observe(MenuObserver::class);
    }
}
