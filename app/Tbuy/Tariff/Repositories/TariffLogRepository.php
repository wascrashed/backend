<?php

namespace App\Tbuy\Tariff\Repositories;

use App\Tbuy\Tariff\DTOs\TariffLogFilterDTO;
use Illuminate\Database\Eloquent\Collection;

interface TariffLogRepository
{
    public function get(TariffLogFilterDTO $payload):Collection;
}
