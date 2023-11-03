<?php

namespace App\Tbuy\Search\Enums;

use App\Traits\SetKeys;

enum CacheKey: string
{
    use SetKeys;

    case SEARCHABLE_MODEL = 'searchable-model';

    case SEARCHABLE_FIELD = 'searchable-field';

    public static function ttl(): int
    {
        return 3600 * 24;
    }
}
