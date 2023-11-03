<?php

namespace App\Tbuy\Reason\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasAllTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read int $id
 * @property-read string $reason
 */
class Reason extends Model
{
    use HasFactory, HasAllTranslations, SoftDeletes;

    public array $translatable = [
        'reason'
    ];

    protected $fillable = [
        'reason'
    ];
}
