<?php

namespace App\Tbuy\Attributable\Services;

use App\Enums\MorphType;
use App\Tbuy\Attributable\DTOs\AttributableDTO;
use App\Tbuy\Attributable\DTOs\ExtendNameDTO;
use App\Tbuy\Attributable\Interfaces\Attributable;
use App\Tbuy\Attributable\Models\Attributable as AttributableModel;
use App\Tbuy\Attributable\Repositories\AttributableRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AttributableServiceImplementation implements AttributableService
{
    public function __construct(
        private readonly AttributableRepository $attributableRepository
    )
    {
    }

    public function prepareAndCreate(Attributable $attributable, Collection $collection): Attributable
    {
        $payload = $this->preparePayload($collection);
        $attributable->attributesList()->delete();

        return DB::transaction(fn() => $this->attributableRepository->setAttribute($attributable, $payload));
    }

    public function preparePayload(Collection $collection): Collection
    {
        return $collection->map(function (AttributableDTO $dto) {
            return $dto->toArray();
        });
    }

    public function removeExistingAttributeValues(Attributable $attributable, Collection $payload): Collection
    {
        $type = MorphType::getType($attributable::class);
        $id = $attributable->id;

        $this->attributableRepository->get($type, $id)
            ->each(function (AttributableModel $attributable) use (&$payload) {
                $keys = $payload->where('attribute_id', $attributable->attribute_id)->keys();
                if ($keys->isNotEmpty()) {
                    unset($payload[$keys[0]]);
                }
            });

        return $payload;
    }

    public function prepareAndSetIsNameTrue(Attributable $attributable, Collection $payload): Attributable
    {
        return $this->attributableRepository->setIsNameTrue($attributable, $payload);
    }
}
