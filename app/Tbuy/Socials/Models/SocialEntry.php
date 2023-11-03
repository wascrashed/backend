<?php

namespace App\Tbuy\Socials\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialEntry extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'social_image',
        'socialable_id',
        'socialable_type',
    ];

    /**
     * @return MorphTo
     * @relationMorphColumn social_entryable
     */
    public function socialEntryable(): MorphTo
    {
        return $this->morphTo('social_entryable');
    }
}
