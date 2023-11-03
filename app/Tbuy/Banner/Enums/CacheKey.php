<?php

namespace App\Tbuy\Banner\Enums;

use App\Traits\SetKeys;

enum CacheKey: string
{
    use SetKeys;

    case BANNER_TAG = 'banner-tag';
    case LIST = 'list';
    case BANNER_DUR = 'banner-dur';

    public static function ttl(): int
    {
        return 3600 * 24;
    }
}
