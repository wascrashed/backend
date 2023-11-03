<?php

namespace App\Tbuy\Settings\Enums;

enum SettingsCacheKey: string
{
    case LIST = 'settings-list';

    public static function ttl(): int
    {
        return 3_600 * 24; // 24 hours
    }
}
