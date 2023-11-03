<?php

namespace App\Tbuy\User\Providers;

use App\Tbuy\User\Repositories\Auth\AuthRepository;
use App\Tbuy\User\Repositories\Auth\AuthRepositoryImplementation;
use App\Tbuy\User\Repositories\UserRepository;
use App\Tbuy\User\Repositories\UserRepositoryImplementation;
use App\Tbuy\User\Services\Auth\AuthService;
use App\Tbuy\User\Services\Auth\AuthServiceImplementation;
use App\Tbuy\User\Services\UserService;
use App\Tbuy\User\Services\UserServiceImplementation;
use Illuminate\Support\ServiceProvider;

class BindingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(AuthService::class, AuthServiceImplementation::class);
        $this->app->bind(UserRepository::class, UserRepositoryImplementation::class);
        $this->app->bind(UserService::class, UserServiceImplementation::class);
        $this->app->bind(AuthRepository::class, AuthRepositoryImplementation::class);

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
