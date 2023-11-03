<?php

namespace App\Tbuy\Tariff\Services;

use App\Tbuy\Tariff\DTOs\TariffLogFilterDTO;
use Illuminate\Database\Eloquent\Collection;

interface TariffLogService
{
    public function getWithCache(TariffLogFilterDTO $filter): Collection;
}
