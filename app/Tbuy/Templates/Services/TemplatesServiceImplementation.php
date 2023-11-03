<?php

namespace App\Tbuy\Templates\Services;

use App\Tbuy\Templates\DTOs\TemplatesDTO;
use App\Tbuy\Templates\Enums\CacheKey;
use App\Tbuy\Templates\Models\Templates;
use App\Tbuy\Templates\Repositories\TemplatesRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class TemplatesServiceImplementation implements TemplatesService
{
    public function __construct(
        private readonly TemplatesRepository $templateRepositroy
    )
    {
    }

    public function getWithCache(): Collection
    {
        return Cache::tags(CacheKey::TEMPLATES_TAG->value)
            ->remember(
                key: CacheKey::LIST->value,
                ttl: CacheKey::ttl(),
                callback: fn() => $this->templateRepositroy->get()
            );
    }

    public function createAndClearCache(TemplatesDTO $payload): Templates
    {
        $banner = $this->templateRepositroy->create($payload);

        Cache::tags(CacheKey::TEMPLATES_TAG->value)->clear();

        return $banner;
    }

    public function updateAndClearCache(Templates $banner, TemplatesDTO $payload): Templates
    {
        $this->templateRepositroy->update($banner, $payload);

        Cache::tags(CacheKey::TEMPLATES_TAG->value)->clear();

        return $banner;
    }

    public function deleteAndClearCache(Templates $banner): void
    {
        $this->templateRepositroy->delete($banner);

        Cache::tags(CacheKey::TEMPLATES_TAG->value)->clear();
    }
}
