<?php

namespace App\Tbuy\MenuUserPermission\Services;

use App\Tbuy\MenuUserPermission\DTOs\MenuUserDTO;
use App\Tbuy\User\Models\User;

interface MenuUserService
{
    public function create(MenuUserDTO $payload): void;
}
