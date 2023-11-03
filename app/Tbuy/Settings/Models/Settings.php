<?php

namespace App\Tbuy\Settings\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Settings extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type',
        'variable',
        'value'
    ];
}
