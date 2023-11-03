<?php

namespace App\Tbuy\Employee\DTOs;

use Illuminate\Support\Str;

class EmployeeDTO
{
    public string $password;

    public function __construct(
        public readonly int    $company_id,
        public readonly string $email,
        public readonly string $username,
        ?string                $password = null
    )
    {
        $this->password = $password ?: Str::password(8);
    }
}
