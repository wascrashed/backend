<?php

namespace App\Tbuy\Tariff\Services;

use App\Tbuy\Tariff\DTOs\PriceDTO;
use App\Tbuy\Tariff\DTOs\TariffBuyDTO;
use App\Tbuy\Tariff\DTOs\TariffDTO;
use App\Tbuy\Tariff\Enums\CacheKey;
use App\Tbuy\Tariff\Exceptions\BalanceNotEnoughException;
use App\Tbuy\Tariff\Models\Tariff;
use App\Tbuy\Tariff\Repositories\TariffPrivilegeRepository;
use App\Tbuy\Tariff\Repositories\TariffRepository;
use App\Tbuy\User\Models\User;
use App\Tbuy\User\Services\UserService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class TariffServiceImplementation implements TariffService
{
    public function __construct(
        protected readonly TariffPrivilegeRepository $tariffPrivilegeRepository,
        protected readonly TariffRepository          $tariffRepository,
        protected readonly UserService               $userService
    )
    {
    }

    public function get(): Collection
    {
        return Cache::tags(CacheKey::TARIFF_TAG->value)
            ->remember(
                CacheKey::TARIFF_LIST->value,
                CacheKey::ttl(),
                fn() => $this->tariffRepository->get()
            );
    }

    public function create(TariffDTO $dto): Tariff
    {
        /** @var Tariff $tariff */
        $tariff = DB::transaction(function () use ($dto) {
            $tariff = $this->tariffRepository->create($dto);
            $this->tariffPrivilegeRepository->create($tariff, $dto->privileges);
            return $tariff->load('privileges');
        });

        Cache::tags(CacheKey::TARIFF_TAG->value)->clear();

        return $tariff;
    }

    public function update(Tariff $tariff, TariffDTO $dto): Tariff
    {
        $tariff = DB::transaction(function () use ($tariff, $dto) {
            $tariff = $this->tariffRepository->update($tariff, $dto);

            $this->tariffPrivilegeRepository->update($tariff, $dto->privileges);

            return $tariff->load('privileges');
        });

        Cache::tags(CacheKey::TARIFF_TAG->value)->clear();

        return $tariff;
    }

    public function delete(Tariff $tariff): void
    {
        $this->tariffRepository->delete($tariff);

        Cache::tags(CacheKey::TARIFF_TAG->value)->clear();
    }

    public function buy(Tariff $tariff, TariffBuyDTO $dto): User
    {
        $price = $this->getPrice($tariff->price, $dto->term_month);
        $this->ensureIsEnoughBalance($tariff, $price);

        return DB::transaction(function () use ($dto, $tariff, $price) {
            $expired_at = Carbon::now()->addMonths($dto->term_month)->endOfDay();

            /** @var User $user */
            $user = auth()->user();

            $this->tariffRepository->activateCompany($user, $tariff, $expired_at);

            $this->tariffRepository->activateUser($user, $tariff, $dto, $price, $expired_at);

            $this->tariffRepository->logTariffActivation($user, $tariff, $price, $dto);

            return $this->userService->expendBalance($user, $price);
        });
    }

    /**
     * @throws BalanceNotEnoughException
     */
    private function ensureIsEnoughBalance(Tariff $tariff, int|float $price): void
    {
        /** @var User $user */
        $user = auth()->user();

        if ($user->balance < $price) {
            throw new BalanceNotEnoughException('Недостаточно средств');
        }
    }

    private function getPrice(SupportCollection $collection, int $term_month): int|float
    {
        /** @var PriceDTO $priceDTO */
        $priceDTO = $collection->where('months', $term_month)->first();

        return $priceDTO->discount_price ?: $priceDTO->price;
    }
}
