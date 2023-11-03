<?php

namespace App\Tbuy\Tariff\Enums;

use App\Traits\SetKeys;

enum CacheKey: string
{
    use SetKeys;

    case TARIFF_LIST = 'tariff-list';
    case TARIFF_TAG = 'tariff tag';

    case TARIFF_LOG_TAG = 'tariff log tag';
    case TARIFF_LOG_LIST = 'tariff log list';

    public static function ttl(): int
    {
        return 3_600 * 24; // 24 hours
    }
}
