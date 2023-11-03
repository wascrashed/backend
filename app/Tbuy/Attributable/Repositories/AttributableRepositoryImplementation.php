<?php

namespace App\Tbuy\Attributable\Repositories;

use App\Tbuy\Attributable\DTOs\ExtendNameDTO;
use App\Tbuy\Attributable\Interfaces\Attributable;
use App\Tbuy\Attributable\Models\Attributable as AttributableModel;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

class AttributableRepositoryImplementation implements AttributableRepository
{
    public function get(string $type, int $id): EloquentCollection
    {
        return AttributableModel::query()
            ->where('attributable_type', $type)
            ->where('attributable_id', $id)
            ->get();
    }

    public function latest(string $type, int $id): ?AttributableModel
    {
        /** @var AttributableModel $attributable */
        $attributable = AttributableModel::query()
            ->where('attributable_type', $type)
            ->where('attributable_id', $id)
            ->latest()
            ->latest('id')
            ->first();

        return $attributable;
    }

    public function setAttribute(Attributable $attributable, Collection $payload): Attributable
    {
        $attributable->attributesList()->createMany($payload);

        return $attributable->load('attributesList');
    }

    public function setIsNameTrue(Attributable $attributable, Collection $payload): Attributable
    {
        $payload->each(
            fn(ExtendNameDTO $dto) => $attributable->attributesList()
                ->where('attribute_id', $dto->attribute_id)
                ->update(['is_name_part' => $dto->is_name_part])
        );

        return $attributable->load('attributesList');
    }
}
