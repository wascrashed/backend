<?php

namespace App\Tbuy\Community\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read int $id
 */
class Community extends Model
{
    use HasFactory, SoftDeletes;
}
