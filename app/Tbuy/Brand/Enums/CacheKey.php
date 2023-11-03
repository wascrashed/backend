<?php

namespace App\Tbuy\Brand\Enums;

use App\Traits\SetKeys;

enum CacheKey: string
{
    use SetKeys;

    case BRAND_LIST = 'brand-list';

    case BRAND_TAG = 'brand tag';

    public static function ttl(): int
    {
        return 3_600 * 24; // 24 hours
    }
}
