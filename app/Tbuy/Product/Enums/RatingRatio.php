<?php

namespace App\Tbuy\Product\Enums;

enum RatingRatio: int
{
    case COMPLAINT_INDIVIDUAL = -5;
    case SERVICE_COMPLAINT_ENTITY = -8;
    case PRODUCT_COMPLAINT_ENTITY = -50;

    public function calculate(int $amount): int
    {
        return $this->value * $amount;
    }
}
