<?php

namespace App\Tbuy\Rejection\Repository;

use App\Tbuy\Brand\DTOs\Rejection\RejectionFilterDTO;
use App\Tbuy\Rejection\DTOs\RejectionableDTO;
use App\Tbuy\Rejection\DTOs\RejectionDTO;
use App\Tbuy\Rejection\Interfaces\Rejectionable;
use App\Tbuy\Rejection\Models\Rejection;
use Illuminate\Database\Eloquent\Collection;

interface RejectionRepository
{
    public function get(RejectionFilterDTO $filters): Collection;

    public function create(Rejectionable $rejectionable, RejectionableDTO $payload, int $user_id): Rejectionable;

    public function update(Rejection $rejection, RejectionDTO $dto): Rejection;
}
