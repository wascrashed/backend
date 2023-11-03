<?php

namespace App\Tbuy\Company\Casts;

use App\Tbuy\Company\DTOs\PhonesDTO;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class Phones implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param array<string, mixed> $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): PhonesDTO
    {
        $phones = is_null($value) ? [] : json_decode($value, true);

        return new PhonesDTO(...$phones);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param PhonesDTO $value
     * @param array<string, mixed> $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        return json_encode($value->toArray());
    }
}
