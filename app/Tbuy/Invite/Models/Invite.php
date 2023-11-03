<?php

namespace App\Tbuy\Invite\Models;

use App\Tbuy\Company\Models\Company;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * @property-read int $id
 * @property int $company_id
 * @property string $email
 * @property string $username
 * @property string $token
 * @property Carbon $expired_at
 * @property Carbon $activated_at
 * @property-read Company $company
 * @property-read bool $is_expired
 * @property-read bool $is_not_expired
 */
class Invite extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'company_id',
        'email',
        'username',
        'token',
        'expired_at',
        'activated_at'
    ];

    protected $casts = [
        'expired_at' => 'datetime',
        'activated_at' => 'datetime',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function isExpired(): Attribute
    {
        return Attribute::get(fn() => $this->expired_at->diffInSeconds(now()) < 0);
    }

    public function isNotExpired(): Attribute
    {
        return Attribute::get(fn() => $this->expired_at->diffInSeconds(now()) > 0);
    }
}
