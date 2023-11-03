<?php

namespace App\Tbuy\MenuUserPermission\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read int $id
 * @property int $menu_id
 * @property int $user_id
 */
class MenuUserPermission extends Pivot
{
    use SoftDeletes;
}
