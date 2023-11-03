<?php

namespace App\Tbuy\Tariff\Models;

use App\Tbuy\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property-read int $id
 * @property int $user_id
 * @property int $tariff_id
 * @property int $price
 * @property int $term_month
 * @property Carbon $expired_at
 * @property-read User $user
 * @property-read Tariff $tariff
 */
class TariffUser extends Model
{
    protected $table = 'tariff_user';

    protected $fillable = [
        'user_id',
        'tariff_id',
        'price',
        'term_month',
        'expired_at'
    ];

    protected $casts = [
        'expired_at' => 'date'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tariff(): BelongsTo
    {
        return $this->belongsTo(Tariff::class);
    }
}
