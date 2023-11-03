<?php

namespace App\Tbuy\Brand\Providers;

use App\Tbuy\Brand\Events\BrandRejected;
use App\Tbuy\Brand\Listeners\BrandRejectedListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        BrandRejected::class => [
            BrandRejectedListener::class,
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
