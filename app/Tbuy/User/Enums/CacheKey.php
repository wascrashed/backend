<?php
 
namespace App\Tbuy\User\Enums;

use App\Traits\SetKeys;
enum CacheKey: string
{
     use SetKeys;

    case USER_LIST = 'user-list';
 
    public static function ttl(): int
    {
        return 3_600 * 24; // 24 hours
    }
}    