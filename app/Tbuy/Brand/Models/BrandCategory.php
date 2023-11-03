<?php

namespace App\Tbuy\Brand\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $brand_id
 * @property int $category_id
 */
class BrandCategory extends Pivot
{
    use HasFactory, SoftDeletes;

    public $timestamps = false;

    protected $primaryKey = null;

    protected $fillable = [
        'brand_id',
        'category_id'
    ];
}
