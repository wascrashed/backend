<?php

namespace App\Tbuy\Employee\Enums;

use App\Traits\SetKeys;

enum CacheKey: string
{
    use SetKeys;

    case TAG = 'employee tag';
    case LIST = 'employee-list';

    public static function ttl(): int
    {
        return 3600 * 24;
    }
}
