<?php

namespace App\Tbuy\Reason\Repositories;

use App\Tbuy\Brand\DTOs\Reason\ReasonCreateDTO;
use App\Tbuy\Brand\Repositories\Reason\ReasonRepository;
use App\Tbuy\Reason\Models\Reason;

class ReasonServiceImplementation implements ReasonService
{
    public function __construct(
        private readonly ReasonRepository $reasonRepository,
    )
    {
    }

    public function findOrCreate(ReasonCreateDTO $reasonCreateDTO): Reason
    {
        return $this->reasonRepository->findOrCreate($reasonCreateDTO);
    }
}
