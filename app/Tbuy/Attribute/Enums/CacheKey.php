<?php

namespace App\Tbuy\Attribute\Enums;

enum CacheKey: string
{
    case TAG_NAME = 'attribute-tag';

    case LIST = 'list';

    public static function ttl(): int
    {
        return 3600 * 24;
    }
}
