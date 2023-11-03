<?php

namespace App\Tbuy\Tariff\DTOs;

class TariffBuyDTO
{
    public function __construct(
        public readonly int $term_month
    )
    {
    }
}
