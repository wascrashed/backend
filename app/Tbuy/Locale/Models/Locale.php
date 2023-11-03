<?php

namespace App\Tbuy\Locale\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read int $id
 * @property string $name
 * @property string $locale
 * @property boolean $is_main
 */
class Locale extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'locale',
        'is_main'
    ];
}
