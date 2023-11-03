<?php

namespace App\Tbuy\Brand\Enums;

use App\Traits\SetKeys;

enum RejectionCacheKey: string
{
    use SetKeys;

    case REJECTION_LIST = 'rejection-list';
    case REJECTION_TAG = 'rejection-tag';

    public static function ttl(): int
    {
        return 3600 * 24;
    }
}
