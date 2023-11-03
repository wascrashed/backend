<?php

namespace App\Tbuy\Tariff\Repositories;

use App\Tbuy\Tariff\Models\Tariff;
use Illuminate\Support\Collection;

interface TariffPrivilegeRepository
{
    public function create(Tariff $tariff, Collection $privileges): Tariff;

    public function update(Tariff $tariff, Collection $privileges): Tariff;
}
