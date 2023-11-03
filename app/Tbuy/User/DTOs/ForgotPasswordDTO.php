<?php

namespace App\Tbuy\User\DTOs;

class ForgotPasswordDTO
{
    public function __construct(
        public readonly string $email,
    )
    {
    }
}
