<?php

namespace App\Tbuy\Tariff\Repositories;

use App\Tbuy\Tariff\DTOs\TariffLogFilterDTO;
use App\Tbuy\Tariff\Models\TariffLog;
use Illuminate\Database\Eloquent\Collection;

class TariffLogRepositoryImplementation implements TariffLogRepository
{
    public function get(TariffLogFilterDTO $payload): Collection
    {
        return TariffLog::query()
            ->filter($payload->toArray())
            ->get();
    }
}
