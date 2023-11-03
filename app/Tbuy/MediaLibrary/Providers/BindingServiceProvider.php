<?php

namespace App\Tbuy\MediaLibrary\Providers;

use App\Tbuy\MediaLibrary\Repositories\MediaLibraryRepository;
use App\Tbuy\MediaLibrary\Repositories\MediaLibraryRepositoryImplementation;
use Illuminate\Support\ServiceProvider;

class BindingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(MediaLibraryRepository::class, MediaLibraryRepositoryImplementation::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
