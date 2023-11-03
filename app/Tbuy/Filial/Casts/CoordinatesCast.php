<?php

namespace App\Tbuy\Filial\Casts;

use App\Tbuy\Filial\DTOs\CoordinateDTO;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class CoordinatesCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param array<string, mixed> $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        list($latitude, $longitude) = explode(",", $value);

        return new CoordinateDTO(
            latitude: $latitude,
            longitude: $longitude
        );
    }

    /**
     * Prepare the given value for storage.
     *
     * @param CoordinateDTO $value
     * @param array<string, mixed> $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return "$value->latitude,$value->longitude";
    }
}
