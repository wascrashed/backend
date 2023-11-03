<?php

namespace App\Tbuy\Menu\Enums;

enum CacheKey: string
{
    case MENU_LIST = 'menu-list';

    public static function ttl(): int
    {
        return 3600 * 24; // 24 hours
    }
}
