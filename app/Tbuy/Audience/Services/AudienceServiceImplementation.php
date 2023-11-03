<?php

namespace App\Tbuy\Audience\Services;

use App\Tbuy\Audience\DTOs\AudienceDTO;
use App\Tbuy\Audience\Enums\CacheKey;
use App\Tbuy\Audience\Models\Audience;
use App\Tbuy\Audience\Repositories\AudienceRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class AudienceServiceImplementation implements AudienceService
{
    public function __construct(
        private readonly AudienceRepository $audienceRepository
    )
    {
    }

    public function get(): Collection
    {
        return Cache::tags(CacheKey::AUDIENCE_TAG->value)
            ->remember(
                CacheKey::AUDIENCE_LIST->value,
                CacheKey::ttl(),
                function () {
                    return $this->audienceRepository->get();
                }
            );
    }

    public function create(AudienceDTO $dto): Audience
    {
        $audience = $this->audienceRepository->create($dto);

        Cache::tags(CacheKey::AUDIENCE_TAG->value)->clear();

        return $audience;
    }

    public function show(Audience $audience): Audience
    {
        return $this->audienceRepository->show($audience);
    }

    public function update(AudienceDTO $dto, Audience $audience): Audience
    {
        $audience = $this->audienceRepository->update($dto, $audience);

        Cache::tags(CacheKey::AUDIENCE_TAG->value)->clear();

        return $audience;
    }

    public function delete(Audience $audience): void
    {
        $this->audienceRepository->delete($audience);

        Cache::tags(CacheKey::AUDIENCE_TAG->value)->clear();
    }
}
