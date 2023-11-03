<?php

namespace App\Tbuy\Bank\Models;

use App\Tbuy\Bank\Enums\Type;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankRatingHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'bank_rating_histories';

    protected $fillable = [
        'bank_id',
        'score',
        'type',
    ];

    protected $casts = [
        'type' => Type::class,
    ];

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }
}
