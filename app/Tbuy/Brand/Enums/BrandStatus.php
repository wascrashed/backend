<?php

namespace App\Tbuy\Brand\Enums;

enum BrandStatus: string
{
    case ACCEPTED = 'accepted';
    case PENDING = 'pending';
    case REJECTED = 'rejected';

    public function isRejected(): bool
    {
        return $this->value === self::REJECTED->value;
    }
}
