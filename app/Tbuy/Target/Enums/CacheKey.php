<?php

namespace App\Tbuy\Target\Enums;

use App\Traits\SetKeys;

enum CacheKey: string
{
    use SetKeys;

    case TARGET_LIST = 'target-list';
    case TARGET_TAG = 'target tag';

    public static function ttl(): int
    {
        return 3_600 * 24; // 24 hours
    }
}
