<?php

namespace App\Tbuy\Target\Models;

use App\Tbuy\Audience\Models\Audience;
use App\Tbuy\Target\Enums\Status;
use App\Traits\HasAllTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property-read int $id
 * @property int $audience_id
 * @property string $targetable_type
 * @property int $targetable_id
 * @property string $name
 * @property string $link
 * @property int $duration
 * @property Status $status
 * @property int $views
 * @property Carbon $started_at
 * @property Carbon $finished_at
 * @property-read Audience $audience
 * @property-read Model $targetable
 */
class Target extends Model
{
    use HasFactory, HasAllTranslations, SoftDeletes;

    protected $fillable = [
        'audience_id',
        'targetable_type',
        'targetable_id',
        'name',
        'link',
        'duration',
        'status',
        'views',
        'started_at',
        'finished_at',
    ];

    protected $casts = [
        'status' => Status::class,
        'started_at' => 'datetime',
        'finished_at' => 'datetime'
    ];

    public array $translatable = [
        'name'
    ];

    public function audience(): BelongsTo
    {
        return $this->belongsTo(Audience::class, 'audience_id', 'id');
    }

    public function targetable(): MorphTo
    {
        return $this->morphTo();
    }
}
