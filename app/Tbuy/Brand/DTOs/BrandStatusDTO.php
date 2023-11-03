<?php

namespace App\Tbuy\Brand\DTOs;

use App\DTOs\BaseDTO;
use App\Tbuy\Brand\Enums\BrandStatus;
use App\Tbuy\Rejection\DTOs\RejectionableDTO;

class BrandStatusDTO extends BaseDTO implements RejectionableDTO
{
    public
    readonly BrandStatus $status;

    public function __construct(
        string               $status,
        public readonly ?int $reason_id = null
    )
    {
        $this->status = BrandStatus::tryFrom($status);
    }

    public function reasonId(): ?int
    {
        return $this->reason_id;
    }
}
