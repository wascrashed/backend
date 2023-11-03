<?php

namespace App\Tbuy\Tariff\Repositories;

use App\Tbuy\Tariff\DTOs\TariffPrivilegeDTO;
use App\Tbuy\Tariff\Models\Tariff;
use Illuminate\Support\Collection;

class TariffPrivilegeRepositoryImplementation implements TariffPrivilegeRepository
{
    public function create(Tariff $tariff, Collection $privileges): Tariff
    {
        $tariff->privileges()
            ->createMany(
                records: $privileges->map(
                    fn(TariffPrivilegeDTO $privilege) => $privilege->toArray()
                )->toArray()
            );

        return $tariff;
    }

    public function update(Tariff $tariff, Collection $privileges): Tariff
    {
        $tariff->privileges()->delete();

        return $this->create($tariff, $privileges);
    }
}
