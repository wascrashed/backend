<?php

namespace App\Tbuy\Tariff\Services;

use App\Tbuy\Tariff\DTOs\TariffBuyDTO;
use App\Tbuy\Tariff\DTOs\TariffDTO;
use App\Tbuy\Tariff\Exceptions\BalanceNotEnoughException;
use App\Tbuy\Tariff\Models\Tariff;
use App\Tbuy\User\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface TariffService
{
    public function get(): Collection;

    public function create(TariffDTO $dto): Tariff;

    public function update(Tariff $tariff, TariffDTO $dto): Tariff;

    public function delete(Tariff $tariff): void;

    /**
     * @param Tariff $tariff
     * @param TariffBuyDTO $dto
     * @return User
     * @throws BalanceNotEnoughException
     */
    public function buy(Tariff $tariff, TariffBuyDTO $dto): User;
}
