<?php

namespace App\Tbuy\Filial\DTOs;

class CoordinateDTO
{
    public function __construct(
        public readonly string $latitude,
        public readonly string $longitude
    )
    {
    }
}
