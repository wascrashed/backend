<?php

namespace App\Tbuy\Tariff\DTOs;

use App\DTOs\BaseDTO;

class PriceDTO extends BaseDTO
{
    public function __construct(
        public readonly float  $price,
        public readonly ?float $discount_price,
        public readonly int    $months

    )
    {
    }
}
