<?php

namespace App\Tbuy\Country\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read int $id
 */
class Country extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = false;
}
