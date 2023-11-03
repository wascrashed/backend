<?php

namespace App\Tbuy\Tariff\Models;

use App\Tbuy\Company\Models\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property-read int $id
 * @property int $company_id
 * @property int $tariff_id
 * @property Carbon $expired_at
 * @property-read Company $company
 * @property-read Tariff $tariff
 */
class TariffCompany extends Model
{
    protected $table = 'company_tariff';

    protected $fillable = [
        'company_id',
        'tariff_id',
        'expired_at'
    ];

    protected $casts = [
        'expired_at' => 'date'
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function tariff(): BelongsTo
    {
        return $this->belongsTo(Tariff::class);
    }
}
