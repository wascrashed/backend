<?php

namespace App\Tbuy\Company\Enums;

enum RatingRatio: int
{
    case AMOUNT_DEFICIENCY = -8;
    case AMOUNT_DEFICIENCY_LEGAL_ENTITY = -4;

    case HAS_TARIFF = 1000;

    case PRODUCT_IMAGES_DIVISION_ON_PRODUCTS_SERVICE = 5;
    case PRODUCT_IMAGES_DIVISION_ON_PRODUCTS_SALES = 3;
    case PRODUCT_IMAGES_DIVISION_ON_PRODUCTS = 4;

    case SOCIAL_ENTRY = 20;
    case SOCIAL_ENTRY_LEGAL_ENTITY_SALES = 100;
    case SOCIAL_ENTRY_LEGAL_ENTITY_SERVICES = 200;
    case PURCHASES_REFUNDS = 500;
    case HAS_PROMOTION = 7;


    public function calculate(int|float $amount): int|float
    {
        return $this->value * $amount;
    }
}
