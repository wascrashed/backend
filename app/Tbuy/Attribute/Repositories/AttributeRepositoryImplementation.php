<?php

namespace App\Tbuy\Attribute\Repositories;

use App\Tbuy\Attribute\DTOs\AttributeDTO;
use App\Tbuy\Attribute\Models\Attribute;
use Illuminate\Database\Eloquent\Collection;

class AttributeRepositoryImplementation implements AttributeRepository
{
    public function get(): Collection
    {
        return Attribute::query()
            ->with('values')
            ->get();
    }

    public function findById(int $attribute_id): Attribute
    {
        /** @var Attribute $attribute */
        $attribute = Attribute::query()->findOrFail($attribute_id);

        return $attribute;
    }

    public function create(AttributeDTO $payload): Attribute
    {
        $attribute = new Attribute();
        $attribute = $this->addTranslations($attribute, $payload);
        $attribute->save();

        return $attribute;
    }

    private function addTranslations(Attribute $attribute, AttributeDTO $payload): Attribute
    {
        $attribute->setTranslations('name', $payload->name);

        return $attribute;
    }

    public function update(Attribute $attribute, AttributeDTO $payload): Attribute
    {
        $attribute = $this->addTranslations($attribute, $payload);
        $attribute->save();

        return $attribute;
    }

    public function delete(Attribute $attribute): void
    {
        $attribute->delete();
    }
}
