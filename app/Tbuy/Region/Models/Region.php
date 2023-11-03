<?php

namespace App\Tbuy\Region\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read int $id
 */
class Region extends Model
{
    use HasFactory, SoftDeletes;
}
