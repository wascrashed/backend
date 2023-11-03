<?php

namespace App\Tbuy\Tariff\Models;

use App\Traits\HasAllTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read int $id
 * @property string $name
 */
class TariffPrivilege extends Model
{
    use HasFactory, HasAllTranslations;

    protected $fillable = [
        'name',
        'tariff_id'
    ];

    public array $translatable = [
        'name'
    ];

    public $timestamps = false;
}
