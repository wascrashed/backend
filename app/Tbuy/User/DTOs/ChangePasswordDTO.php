<?php

namespace App\Tbuy\User\DTOs;

class ChangePasswordDTO
{
    public function __construct(
        public readonly string $oldPassword,
        public readonly string $password,
    )
    {
    }
}
