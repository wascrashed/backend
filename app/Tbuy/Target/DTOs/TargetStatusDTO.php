<?php

namespace App\Tbuy\Target\DTOs;

class TargetStatusDTO
{
    public function __construct(
        public readonly string $status
    )
    {}
}
