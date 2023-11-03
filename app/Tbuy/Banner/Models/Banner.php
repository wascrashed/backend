<?php

namespace App\Tbuy\Banner\Models;

use App\Tbuy\Banner\Filters\BannerFilter;
use App\Tbuy\Banner\Filters\CompanyFilter;
use App\Tbuy\Company\Models\Company;
use App\Traits\FilterTrait;
use App\Traits\HasAllTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read int $id
 * @property string $name
 * @property array $content
 * @property int $company_id
 * @property int $banner_id
 * @property-read Company $company
 * @property-read Banner $banner
 */
class Banner extends Model
{
    use HasFactory;
    use FilterTrait, HasAllTranslations, SoftDeletes;

    protected $fillable = [
        'name',
        'content',
        'company_id'
    ];

    public array $translatable = [
        'name'
    ];

    protected $casts = [
        'content' => 'array'
    ];

    protected array $filters = [
        CompanyFilter::class => 'company_id',
        BannerFilter::class => 'id'
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function target(): MorphMany
    {
        return $this->morphMany(Target::class, 'targetable');
    }
}
