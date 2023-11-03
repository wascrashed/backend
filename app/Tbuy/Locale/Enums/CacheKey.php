<?php

namespace App\Tbuy\Locale\Enums;

enum CacheKey: string
{
    case LOCALE_LIST = 'locale-list';

    public static function ttl(): int
    {
        return 3_600 * 24; // 24 hours
    }
}
