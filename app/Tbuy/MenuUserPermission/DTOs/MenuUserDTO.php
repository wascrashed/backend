<?php

namespace App\Tbuy\MenuUserPermission\DTOs;

class MenuUserDTO
{
    public function __construct(
        public readonly int   $user_id,
        public readonly array $menu,
    )
    {
    }
}
