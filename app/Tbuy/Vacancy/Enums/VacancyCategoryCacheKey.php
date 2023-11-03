<?php

namespace App\Tbuy\Vacancy\Enums;

use App\Traits\SetKeys;

enum VacancyCategoryCacheKey: string
{
    use SetKeys;

    case LIST = 'vacancy-category-list';

    public static function ttl(): int
    {
        return 3_600 * 24; // 24 hours
    }
}
