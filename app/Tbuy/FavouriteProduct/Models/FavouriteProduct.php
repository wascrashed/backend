<?php

namespace App\Tbuy\FavouriteProduct\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property-read int $product_id
 * @property-read int $user_id
 * @property Carbon $created_at
 */
class FavouriteProduct extends Pivot
{
    use HasFactory, SoftDeletes;

    public $timestamps = false;

    protected $casts = [
        'created_at' => 'datetime'
    ];
}
