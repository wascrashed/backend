<?php

namespace App\Tbuy\CreditApplication\DTOs;

use Illuminate\Database\Eloquent\Collection;

class CreditApplicationDTO
{
    public function __construct(
        public readonly Collection|array $bankIds,
        public readonly string $userId,
        public readonly string $sum
    )
    {
    }
}
