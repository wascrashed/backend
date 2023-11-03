<?php

namespace App\Tbuy\Brand\Repositories\Reason;

use App\Tbuy\Brand\DTOs\Reason\ReasonCreateDTO;
use App\Tbuy\Reason\Models\Reason;
use Illuminate\Database\Eloquent\Collection;

class ReasonRepositoryImplementation implements ReasonRepository
{
    public function get(): Collection
    {
        return Reason::query()->get();
    }

    public function findOrCreate(ReasonCreateDTO $reasonCreateDTO): Reason
    {
        return Reason::query()->firstOrCreate(['reason' => $reasonCreateDTO->reason]);
    }

    public function findByReason(string $reason): Reason
    {
        return Reason::query()->where('reason', $reason)->first();
    }
}
