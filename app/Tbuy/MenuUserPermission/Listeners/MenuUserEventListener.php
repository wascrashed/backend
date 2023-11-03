<?php

namespace App\Tbuy\MenuUserPermission\Listeners;

use App\Tbuy\MenuUserPermission\Events\MenuUserSet;
use App\Tbuy\User\Repositories\UserRepository;

class MenuUserEventListener
{
    /**
     * Create the event listener.
     */
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    /**
     * Handle the event.
     */
    public function handle(MenuUserSet $event): void
    {
        $this->userRepository->setMenu($event->payload)->load('menus');
    }
}
