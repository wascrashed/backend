<?php

namespace App\Tbuy\Tariff\Services;

use App\Tbuy\Tariff\DTOs\TariffLogFilterDTO;
use App\Tbuy\Tariff\Enums\CacheKey;
use App\Tbuy\Tariff\Repositories\TariffLogRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class TariffLogServiceImplementation implements TariffLogService
{
    public function __construct(
        private readonly TariffLogRepository $tariffLogRepository
    )
    {
    }

    public function getWithCache(TariffLogFilterDTO $filter): Collection
    {
        return Cache::tags(CacheKey::TARIFF_LOG_TAG->value)
            ->remember(
                key: CacheKey::TARIFF_LOG_LIST->setKeys($filter),
                ttl: CacheKey::ttl(),
                callback: fn() => $this->tariffLogRepository->get($filter)->load(['company','user','tariff'])
            );
    }
}
