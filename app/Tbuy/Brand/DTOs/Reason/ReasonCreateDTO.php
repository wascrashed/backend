<?php

namespace App\Tbuy\Brand\DTOs\Reason;

class ReasonCreateDTO
{
    public function __construct(
        readonly string $reason
    )
    {
    }
}
