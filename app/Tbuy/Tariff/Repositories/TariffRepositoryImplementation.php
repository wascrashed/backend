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

class TariffRepositoryImplementation implements TariffRepository
{

    public function get(): Collection
    {
        return Tariff::query()
            ->with('privileges')
            ->get();
    }

    public function create(TariffDTO $dto): Tariff
    {
        $tariff = new Tariff([
            'price' => $dto->price,
            'score' => $dto->score,
            'percent' => $dto->percent
        ]);
        $tariff = $this->addTranslations($dto, $tariff);

        $tariff->save();

        return $tariff;
    }

    public function update(Tariff $tariff, TariffDTO $dto): Tariff
    {
        $tariff->fill([
            'price' => $dto->price,
            'score' => $dto->score,
            'percent' => $dto->percent
        ]);
        $tariff = $this->addTranslations($dto, $tariff);
        $tariff->save();

        return $tariff;
    }

    public function delete(Tariff $tariff): void
    {
        $tariff->delete();
    }

    public function activateCompany(User $user, Tariff $tariff, Carbon $expired_at): TariffCompany
    {
        /** @var TariffCompany $tariff_company */
        $tariff_company = TariffCompany::query()
            ->updateOrCreate([
                'company_id' => $user->company->id
            ], [
                'tariff_id' => $tariff->id,
                'expired_at' => $expired_at
            ]);

        return $tariff_company;
    }

    public function activateUser(User $user, Tariff $tariff, TariffBuyDTO $dto, int|float $price, Carbon $expired_at): TariffUser
    {
        /** @var TariffUser $tariff_user */
        $tariff_user = TariffUser::query()
            ->updateOrCreate([
                'user_id' => $user->id,
            ], [
                'tariff_id' => $tariff->id,
                'price' => $price,
                'term_month' => $dto->term_month,
                'expired_at' => $expired_at
            ]);

        return $tariff_user;
    }

    public function logTariffActivation(User $user, Tariff $tariff, int|float $price, TariffBuyDTO $dto): TariffLog
    {
        /** @var TariffLog $tariff_log */
        $tariff_log = TariffLog::query()->create([
            'user_id' => $user->id,
            'company_id' => $user->company->id,
            'tariff_id' => $tariff->id,
            'months' => $dto->term_month,
            'price' => $price
        ]);

        return $tariff_log;
    }

    private function addTranslations(TariffDTO $dto, Tariff $tariff): Tariff
    {
        return $tariff->setTranslations('name', $dto->name)
            ->setTranslations('description', $dto->description);
    }
}
