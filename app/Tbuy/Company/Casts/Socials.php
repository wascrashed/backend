<?php

namespace App\Tbuy\Company\Casts;

use App\Tbuy\Company\DTOs\SocialsDTO;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class Socials implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param array<string, mixed> $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): SocialsDTO
    {
        $socials = is_null($value) ? [] : json_decode($value, true);

        return new SocialsDTO(...$socials);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param SocialsDTO $value
     * @param array<string, mixed> $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        return json_encode($value->toArray());
    }
}
