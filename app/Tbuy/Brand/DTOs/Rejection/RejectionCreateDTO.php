<?php

namespace App\Tbuy\Brand\DTOs\Rejection;

use App\Tbuy\Brand\Models\Brand;

class RejectionCreateDTO
{
    public function __construct(
        readonly int $brand,
        readonly string $reason,
        readonly int $userId,
        readonly Brand $brandImage,
    )
    {
    }
}
