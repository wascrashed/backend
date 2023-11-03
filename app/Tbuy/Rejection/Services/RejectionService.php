<?php

namespace App\Tbuy\Rejection\Services;

use App\Tbuy\Brand\DTOs\Rejection\RejectionCreateDTO;
use App\Tbuy\Brand\DTOs\Rejection\RejectionFilterDTO;
use App\Tbuy\Rejection\DTOs\RejectionDTO;
use App\Tbuy\Rejection\Models\Rejection;
use Illuminate\Database\Eloquent\Collection;

interface RejectionService
{
    public function get(RejectionFilterDTO $filters): Collection;

    public function create(RejectionCreateDTO $rejectionCreateDTO): Rejection;

    public function update(Rejection $rejection, RejectionDTO $dto): Rejection;
}
