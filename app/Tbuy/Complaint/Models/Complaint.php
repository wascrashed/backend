<?php

namespace App\Tbuy\Complaint\Models;

use App\Tbuy\User\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read int $id
 * @property string $complaintable_type
 * @property string $complaintable_id
 * @property string $complaint
 * @property string|null $lang
 * @property string|null $user_id
 * @property-read User|null $user
 * @property-read $complaintable
 */
class Complaint extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'complaintable_type',
        'complaintable_id',
        'complaint',
        'lang',
        'user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @relationMorphColumn complaintable
     * @return MorphTo
     */
    public function complaintable(): MorphTo
    {
        return $this->morphTo();
    }
}
