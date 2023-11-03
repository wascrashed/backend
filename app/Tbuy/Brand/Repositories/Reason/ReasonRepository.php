<?php

namespace App\Tbuy\Brand\Repositories\Reason;

use App\Tbuy\Brand\DTOs\Reason\ReasonCreateDTO;
use App\Tbuy\Reason\Models\Reason;
use Illuminate\Database\Eloquent\Collection;

interface ReasonRepository
{
    public function get(): Collection;

    public function findOrCreate(ReasonCreateDTO $reasonCreateDTO): Reason;

    public function findByReason(string $reason): Reason;
}
