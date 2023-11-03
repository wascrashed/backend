<?php

namespace App\Tbuy\Attribute\Services;

use App\Tbuy\Attribute\DTOs\AttributeDTO;
use App\Tbuy\Attribute\Enums\CacheKey;
use App\Tbuy\Attribute\Models\Attribute;
use App\Tbuy\Attribute\Repositories\AttributeRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class AttributeServiceImplementation implements AttributeService
{
    public function __construct(private readonly AttributeRepository $attributeRepository)
    {
    }

    public function get(): Collection
    {
        return Cache::tags(CacheKey::TAG_NAME->value)
            ->remember(
                CacheKey::LIST->value,
                CacheKey::ttl(),
                fn() => $this->attributeRepository->get()
            );
    }

    public function create(AttributeDTO $payload): Attribute
    {
        $attribute = $this->attributeRepository->create($payload);

        Cache::tags(CacheKey::TAG_NAME->value)->forget(CacheKey::LIST->value);

        return $attribute;
    }

    public function update(Attribute $attribute, AttributeDTO $payload): Attribute
    {
        $attribute = $this->attributeRepository->update($attribute, $payload);

        Cache::tags(CacheKey::TAG_NAME->value)->forget(CacheKey::LIST->value);

        return $attribute;
    }

    public function delete(Attribute $attribute): void
    {
        $this->attributeRepository->delete($attribute);

        Cache::tags(CacheKey::TAG_NAME->value)->forget(CacheKey::LIST->value);
    }
}
