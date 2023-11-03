<?php

namespace App\Tbuy\Templates\Enums;

use App\Traits\SetKeys;

enum CacheKey: string
{
    use SetKeys;

    case TEMPLATES_TAG = 'templates-tag';

    case LIST = 'list';

    public static function ttl(): int
    {
        return 3600 * 24;
    }
}
