<?php

namespace App\Tbuy\CreditApplication\Models;

use App\Tbuy\Bank\Models\Bank;
use App\Tbuy\CreditApplication\Enums\Status;
use App\Tbuy\User\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreditApplication extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'credit_applications';

    protected $fillable = [
        'user_id',
        'requested_sum',
        'status',
    ];

    protected $casts = [
        'status' => Status::class,
    ];

    public function banks(): BelongsToMany
    {
        return $this->belongsToMany(Bank::class)
            ->withPivot(['sum', 'status'])
            ->withTimestamps();
    }

    public function selectedBank(): BelongsToMany
    {
        return $this->banks()->where('status', Status::SELECTED->value)->take(1);
    }

    public function acceptedAndProfitableBank(): BelongsToMany
    {
        return $this->banks()->where('status', Status::ACCEPTED->value)->orderBy('sum')->take(1);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
