<?php

namespace App\Tbuy\Product\DTOs;

use App\Tbuy\Product\Enums\ProductStatus;
use App\Tbuy\Rejection\DTOs\RejectionableDTO;

class ProductToggleStatusDTO implements RejectionableDTO
{
    public function __construct(
        public readonly ProductStatus $status,
        public readonly ?int          $reason_id = null
    )
    {
    }

    public function reasonId(): ?int
    {
        return $this->reason_id;
    }
}
