<?php

namespace App\Tbuy\Tariff\Repositories;

use App\Tbuy\Tariff\DTOs\TariffBuyDTO;
use App\Tbuy\Tariff\DTOs\TariffDTO;
use App\Tbuy\Tariff\Models\Tariff;
use App\Tbuy\Tariff\Models\TariffCompany;
use App\Tbuy\Tariff\Models\TariffLog;
use App\Tbuy\Tariff\Models\TariffUser;
use App\Tbuy\User\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection as SupportCollection;

interface TariffRepository
{
    public function get(): Collection;

    public function create(TariffDTO $dto): Tariff;

    public function update(Tariff $tariff, TariffDTO $dto): Tariff;

    public function delete(Tariff $tariff): void;

    public function activateCompany(User $user, Tariff $tariff, Carbon $expired_at): TariffCompany;

    public function activateUser(User $user, Tariff $tariff, TariffBuyDTO $dto, int|float $price, Carbon $expired_at): TariffUser;

    public function logTariffActivation(User $user, Tariff $tariff, int|float $price, TariffBuyDTO $dto): TariffLog;
}
