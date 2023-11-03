<?php

namespace App\Tbuy\MenuUserPermission\Services;

use App\Tbuy\MenuUserPermission\DTOs\MenuUserDTO;
use App\Tbuy\MenuUserPermission\Events\MenuUserSet;

class MenuUserServiceImplementation implements MenuUserService
{
    public function create(MenuUserDTO $payload):void
    {
        event(new MenuUserSet($payload));
    }
}
