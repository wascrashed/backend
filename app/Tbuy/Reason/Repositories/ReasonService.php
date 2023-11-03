<?php

namespace App\Tbuy\Reason\Repositories;

use App\Tbuy\Brand\DTOs\Reason\ReasonCreateDTO;
use App\Tbuy\Reason\Models\Reason;

interface ReasonService
{
    public function findOrCreate(ReasonCreateDTO $reasonCreateDTO): Reason;
}
