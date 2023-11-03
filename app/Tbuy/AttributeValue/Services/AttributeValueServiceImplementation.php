<?php

namespace App\Tbuy\AttributeValue\Services;

use App\Tbuy\Attribute\Enums\CacheKey;
use App\Tbuy\AttributeValue\DTOs\AttributeValueDTO;
use App\Tbuy\AttributeValue\Models\AttributeValue;
use App\Tbuy\AttributeValue\Repositories\AttributeValueRepository;
use Illuminate\Support\Facades\Cache;

class AttributeValueServiceImplementation implements AttributeValueService
{
    public function __construct(
        private readonly AttributeValueRepository $valueRepository
    )
    {
    }

    public function create(AttributeValueDTO $payload): AttributeValue
    {
        $attributeValue = $this->valueRepository->create($payload);
        Cache::tags(CacheKey::TAG_NAME->value)->forget(CacheKey::LIST->value);

        return $attributeValue->load('attribute');
    }

    public function update(AttributeValue $attributeValue, AttributeValueDTO $payload): AttributeValue
    {
        $attributeValue = $this->valueRepository->update($attributeValue, $payload);
        Cache::tags(CacheKey::TAG_NAME->value)->forget(CacheKey::LIST->value);

        return $attributeValue->load('attribute');
    }

    public function delete(AttributeValue $attributeValue): ?bool
    {
        $value = $this->valueRepository->delete($attributeValue);
        Cache::tags(CacheKey::TAG_NAME->value)->forget(CacheKey::LIST->value);

        return $value;
    }
}
