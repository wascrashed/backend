<?php

namespace App\Tbuy\Rejection\DTOs;

interface RejectionableDTO
{
    public function reasonId(): ?int;
}
