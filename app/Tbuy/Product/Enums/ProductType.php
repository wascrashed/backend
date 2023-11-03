<?php

namespace App\Tbuy\Product\Enums;

enum ProductType: string
{
    case DEFAULT = 'default';
    case GIFT_CARD = 'gift_card';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
