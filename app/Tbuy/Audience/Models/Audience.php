<?php

namespace App\Tbuy\Audience\Models;

use App\Tbuy\Audience\Enums\Gender;
use App\Tbuy\Company\Models\Company;
use App\Tbuy\Country\Models\Country;
use App\Tbuy\Region\Models\Region;
use App\Traits\HasAllTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read int $id
 * @property array $name
 * @property int $company_id
 * @property int $country_id
 * @property int $region_id
 * @property Gender $gender
 * @property array $age
 * @property-read Company $company
 * @property-read Country $country
 * @property-read Region $region
 */
class Audience extends Model
{
    use HasFactory, HasAllTranslations, SoftDeletes;

    protected $fillable = [
        'name',
        'company_id',
        'country_id',
        'region_id',
        'gender',
        'age',
    ];

    protected $casts = [
        'gender' => Gender::class,
        'age' => 'array',
        'deleted_at' => 'date'
    ];

    public array $translatable = [
        'name'
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'region_id', 'id');
    }
}
