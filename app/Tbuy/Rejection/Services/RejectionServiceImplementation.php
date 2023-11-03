<?php

namespace App\Tbuy\Rejection\Services;

use App\Tbuy\Brand\DTOs\Reason\ReasonCreateDTO;
use App\Tbuy\Brand\DTOs\Rejection\RejectionCreateDTO;
use App\Tbuy\Brand\DTOs\Rejection\RejectionFilterDTO;
use App\Tbuy\Brand\Enums\RejectionCacheKey;
use App\Tbuy\Reason\Repositories\ReasonService;
use App\Tbuy\Rejection\DTOs\RejectionDTO;
use App\Tbuy\Rejection\Models\Rejection;
use App\Tbuy\Rejection\Repository\RejectionRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class RejectionServiceImplementation implements RejectionService
{
    public function __construct(
        private readonly RejectionRepository $rejectionRepository,
        private readonly ReasonService       $reasonService,
    )
    {
    }

    public function get(RejectionFilterDTO $filters): Collection
    {
        return Cache::tags(RejectionCacheKey::REJECTION_TAG->value)
            ->remember(
                RejectionCacheKey::REJECTION_LIST->setKeys($filters),
                RejectionCacheKey::ttl(),
                fn() => $this->rejectionRepository->get($filters)
            );
    }

    public function create(RejectionCreateDTO $rejectionCreateDTO): Rejection
    {
        $reasonModel = $this->reasonService->findOrCreate(new ReasonCreateDTO($rejectionCreateDTO->reason));

        $rejection = $this->rejectionRepository->store(new RejectionCreateDTO(
            $rejectionCreateDTO->brand,
            $reasonModel->id,
            $rejectionCreateDTO->userId,
            $rejectionCreateDTO->brandImage,
        ));

        Cache::tags(RejectionCacheKey::REJECTION_TAG)->clear();

        return $rejection;
    }

    public function update(Rejection $rejection, RejectionDTO $dto): Rejection
    {
        $rejection = $this->rejectionRepository->update($rejection, $dto);

        Cache::tags(RejectionCacheKey::REJECTION_TAG)->clear();

        return $rejection;
    }
}
