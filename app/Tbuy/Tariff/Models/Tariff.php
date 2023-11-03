<?php

namespace App\Tbuy\Tariff\Models;

use App\Tbuy\Tariff\Casts\TariffPriceCast;
use App\Tbuy\Tariff\DTOs\PriceDTO;
use App\Traits\HasAllTranslations;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * @property-read int $id
 * @property array $name
 * @property array $description
 * @property Collection<PriceDTO> $price
 * @property int $score
 * @property float $percent
 * @property-read EloquentCollection<TariffPrivilege> $privileges
 */
class Tariff extends Model
{
    use HasFactory, HasAllTranslations, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'price',
        'score',
        'percent'
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
        'price' => TariffPriceCast::class
    ];

    public array $translatable = [
        'name',
        'description',
    ];

    public function privileges(): HasMany
    {
        return $this->hasMany(TariffPrivilege::class);
    }
}
