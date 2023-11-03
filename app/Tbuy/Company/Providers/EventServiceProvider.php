<?php

namespace App\Tbuy\Company\Providers;

use App\Tbuy\Company\Events\CompanyRejected;
use App\Tbuy\Company\Listeners\CompanyRejectedListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        CompanyRejected::class => [
            CompanyRejectedListener::class,
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
