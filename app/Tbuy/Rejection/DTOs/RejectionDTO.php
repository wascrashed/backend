<?php

namespace App\Tbuy\Rejection\DTOs;

class RejectionDTO implements RejectionableDTO
{
    public function __construct(
        protected readonly int $reason_id,
    )
    {
    }

    public function reasonId(): ?int
    {
        return $this->reason_id;
    }
}
