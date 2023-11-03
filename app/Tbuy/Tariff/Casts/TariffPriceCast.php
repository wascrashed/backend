<?php

namespace App\Tbuy\Tariff\Casts;

use App\Tbuy\Tariff\DTOs\PriceDTO;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class TariffPriceCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param array<string, mixed> $attributes
     * @param array<string, mixed> $value
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        $price = $this->getParsedPrice($value);

        return collect(
            array_map(
                fn(array $price_item) => new PriceDTO(...$price_item),
                $price
            )
        );
    }

    /**
     * Prepare the given value for storage.
     *
     * @param array<string, mixed> $attributes
     * @param Collection $value
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {

        return $value->map(
            fn(PriceDTO $price) => $price->toArray()
        )->toJson();
    }

    private function getParsedPrice(?string $value)
    {
        return is_null($value)
            ? []
            : json_decode($value, true);
    }
}
