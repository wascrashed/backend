<?php

namespace App\Tbuy\Comment\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'comments';

    protected $fillable = [
        'commentable_id',
        'commentable_type',
        'user_id',
        'content',
    ];

    /**
     * @relationMorphColumn commentable
     * @return MorphTo
     */
    public function commentable(): MorphTo
    {
        return $this->morphTo('commentable');
    }
}
