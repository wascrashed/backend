<?php

namespace App\Tbuy\Target\Services;

use App\Tbuy\Target\DTOs\TargetDTO;
use App\Tbuy\Target\DTOs\TargetStatusDTO;
use App\Tbuy\Target\Enums\CacheKey;
use App\Tbuy\Target\Models\Target;
use App\Tbuy\Target\Repositories\TargetRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class TargetServiceImplementation implements TargetService
{
    public function __construct(
        private readonly TargetRepository $targetRepository
    )
    {
    }

    public function get(): Collection
    {
        return Cache::tags(CacheKey::TARGET_TAG->value)
            ->remember(
                CacheKey::TARGET_LIST->value,
                CacheKey::ttl(),
                function () {
                    return $this->targetRepository->get();
                }
            );
    }

    public function create(TargetDTO $dto): Target
    {
        $target = $this->targetRepository->create($dto);

        Cache::tags(CacheKey::TARGET_TAG->value)->clear();

        return $target;
    }

    public function show(Target $target): Target
    {
        return $this->targetRepository->show($target);
    }

    public function update(TargetDTO $dto, Target $target): Target
    {
        $target = $this->targetRepository->update($dto, $target);

        Cache::tags(CacheKey::TARGET_TAG->value)->clear();

        return $target;
    }

    public function delete(Target $target): void
    {
        $this->targetRepository->delete($target);

        Cache::tags(CacheKey::TARGET_TAG->value)->clear();
    }

    public function changeStatus(TargetStatusDTO $dto, Target $target): Target
    {
        $target = $this->targetRepository->changeStatus($dto, $target);

        Cache::tags(CacheKey::TARGET_TAG->value)->clear();

        return $target;
    }

    public function incrementViews(Target $target): void
    {
        $this->targetRepository->incrementViews($target);

        Cache::tags(CacheKey::TARGET_TAG->value)->clear();
    }
}
