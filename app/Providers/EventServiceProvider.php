<?php

namespace App\Providers;

use App\Tbuy\Brand\Events\AttachProduct;
use App\Tbuy\Brand\Listeners\AttachProductListener;
use App\Tbuy\Invite\Events\InviteActivatedEvent;
use App\Tbuy\Invite\Listeners\EmployeeCreate;
use App\Tbuy\Invite\Listeners\UserCreate;
use App\Tbuy\MenuUserPermission\Events\MenuUserSet;
use App\Tbuy\MenuUserPermission\Listeners\MenuUserEventListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        MenuUserSet::class => [
            MenuUserEventListener::class
        ],
        AttachProduct::class => [
            AttachProductListener::class
        ],
        InviteActivatedEvent::class => [
            UserCreate::class,
            EmployeeCreate::class
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
