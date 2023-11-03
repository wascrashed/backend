<?php

namespace App\Tbuy\Employee\DTOs;

use App\Traits\SetKeys;

class EmployeeFilterDTO
{
    use SetKeys;

    public function __construct(
        public readonly int $company_id,
        public readonly ?string $username = null,
        public readonly ?string $email = null,
    )
    {
    }

    public static function ttl(): int
    {
        return 3600 * 24; // 24 hours
    }

    public function toArray(): array
    {
        return [
            'company_id' => $this->company_id,
            'username' => $this->username,
            'email' => $this->email
        ];
    }
}
