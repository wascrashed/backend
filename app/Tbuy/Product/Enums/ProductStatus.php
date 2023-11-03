<?php

namespace App\Tbuy\Product\Enums;

enum ProductStatus: string
{
    case REJECTED = 'rejected';
    case CONFIRMED = 'confirmed';
    case WAITING = 'waiting';
    case NEED_UPDATE = 'need_update';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function isRejected(): bool
    {
        return $this->value === self::REJECTED->value;
    }
}
