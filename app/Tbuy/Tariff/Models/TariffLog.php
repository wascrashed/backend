<?php

namespace App\Tbuy\Tariff\Models;

use App\Tbuy\Company\Models\Company;
use App\Tbuy\Tariff\Filters\CompanyIdFilter;
use App\Tbuy\Tariff\Filters\TariffIdFilter;
use App\Tbuy\Tariff\Filters\UserIdFilter;
use App\Tbuy\User\Models\User;
use App\Traits\FilterTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property-read int $id
 * @property int $user_id
 * @property int $company_id
 * @property int $tariff_id
 * @property int $months
 * @property float $price
 * @property Carbon $created_at
 * @property-read User $user
 * @property-read Company $company
 * @property-read Tariff $tariff
 */
class TariffLog extends Model
{
    use HasFactory, FilterTrait;

    protected $fillable = [
        'user_id',
        'company_id',
        'tariff_id',
        'months',
        'price'
    ];

    public array $filters = [
        CompanyIdFilter::class => 'company_id',
        TariffIdFilter::class => 'tariff_id',
        UserIdFilter::class => 'user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function tariff(): BelongsTo
    {
        return $this->belongsTo(Tariff::class);
    }
}
