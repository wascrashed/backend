<?php

namespace App\Tbuy\AttributeValue\Constants;

enum AttributeValueTypeEnum: int
{
    case DEFAULT = 1;
    case COLOR = 2;

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
