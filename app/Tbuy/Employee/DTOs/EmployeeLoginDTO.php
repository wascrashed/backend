<?php

namespace App\Tbuy\Employee\DTOs;

class EmployeeLoginDTO
{
    public function __construct(
        public readonly int    $company_id,
        public readonly string $email,
        public readonly string $password
    )
    {
    }
}
