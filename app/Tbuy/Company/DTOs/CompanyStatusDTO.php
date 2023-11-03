<?php

namespace App\Tbuy\Company\DTOs;

use App\DTOs\BaseDTO;
use App\Tbuy\Company\Enums\CompanyStatus;
use App\Tbuy\Rejection\DTOs\RejectionableDTO;

class CompanyStatusDTO extends BaseDTO implements RejectionableDTO
{
    public readonly CompanyStatus $status;

    public function __construct(
        string               $status,
        public readonly ?int $reason_id = null
    )
    {
        $this->status = CompanyStatus::tryFrom($status);
    }

    public function reasonId(): ?int
    {
        return $this->reason_id;
    }
}
