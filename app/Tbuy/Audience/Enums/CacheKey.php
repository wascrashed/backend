<?php

namespace App\Tbuy\Audience\Enums;

use App\Traits\SetKeys;

enum CacheKey: string
{
    use SetKeys;

    case AUDIENCE_LIST = 'audience-list';
    case AUDIENCE_TAG = 'audience tag';

    public static function ttl(): int
    {
        return 3_600 * 24; // 24 hours
    }
}
