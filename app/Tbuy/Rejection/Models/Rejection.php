<?php

namespace App\Tbuy\Rejection\Models;

use App\Tbuy\Brand\Filters\Rejection\CategoryFilter;
use App\Tbuy\Brand\Filters\Rejection\CompanyFilter as BrandCompanyFilter;
use App\Tbuy\Brand\Filters\Rejection\DateFilter as BrandDateFilter;
use App\Tbuy\Brand\Filters\Rejection\NameFilter as BrandNameFilter;
use App\Tbuy\Brand\Models\Brand;
use App\Tbuy\Company\Filters\RelationsRejectedFilter as CompanyRelationsFilter;
use App\Tbuy\Company\Models\Company;
use App\Tbuy\Filters\DateFilter;
use App\Tbuy\Reason\Models\Reason;
use App\Tbuy\Rejection\Filters\IdFilter;
use App\Tbuy\Rejection\Filters\ReasonFilter;
use App\Tbuy\Rejection\Filters\TypeFilter;
use App\Tbuy\Rejection\Filters\UserFilter;
use App\Tbuy\User\Models\User;
use App\Traits\FilterTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property-read int $id
 * @property int $rejectionable_id
 * @property string $rejectionable_type
 * @property int $user_id
 * @property int $reason_id
 * @property array $image
 * @property Carbon $rejected_at
 * @property-read Carbon $created_at
 * @property-read Brand|Company $rejectionable
 */
class Rejection extends Model
{
    use HasFactory;
    use FilterTrait, SoftDeletes;

    protected $filters = [
        IdFilter::class => null,
        TypeFilter::class => null,
        UserFilter::class => 'user_id',
        DateFilter::class => 'rejected_at',
        ReasonFilter::class => null,
        BrandDateFilter::class => null,
        BrandNameFilter::class => null,
        BrandCompanyFilter::class => null,
        CategoryFilter::class => null,
        CompanyRelationsFilter::class => null
    ];

    protected $fillable = [
        'rejectionable_type',
        'rejectionable_id',
        'user_id',
        'reason_id',
        'brand_id',
        'image',
        'rejected_at'
    ];

    protected $casts = [
        'image' => 'array',
        'rejected_at' => 'datetime'
    ];

    protected $with = [
        'rejectionable'
    ];

    public function rejectionable(): MorphTo
    {
        return $this->morphTo('rejectionable');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reason(): BelongsTo
    {
        return $this->belongsTo(Reason::class);
    }
}
