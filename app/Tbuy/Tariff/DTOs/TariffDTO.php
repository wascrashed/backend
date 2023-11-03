<?php

namespace App\Tbuy\Tariff\DTOs;

use Illuminate\Support\Collection;

class TariffDTO
{
    public function __construct(
        public readonly array      $name,
        public readonly array      $description,
        public readonly Collection      $privileges,
        public readonly Collection $price,
        public readonly int        $score,
        public readonly float      $percent
    )
    {
    }
}
