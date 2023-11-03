<?php

namespace App\Tbuy\Templates\Models;

use App\Traits\HasAllTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Templates extends Model
{
    use HasAllTranslations, HasFactory;

    public array $translatable = ['name'];

    protected $fillable = ['banner_id', 'name'];


}

