<?php

namespace App\Tbuy\Filial\Enums;

use App\Traits\SetKeys;

enum CacheKey: string
{
    use SetKeys;

    case FILIAL_TAG = 'filial-tag';

    case LIST = 'list';

    public static function ttl(): int
    {
        return 3600 * 24; // 24 hours
    }
}
