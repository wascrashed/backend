<?php

namespace App\Tbuy\SearchRatings\Model;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Tbuy\SearchRating\SearchRating
 *
 * @property int $id
 * @property int $ratingable_id
 * @property string $ratingable_type
 * @property int $rating
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Model|Builder $ratingable
 * @method static Builder|SearchRating newModelQuery()
 * @method static Builder|SearchRating newQuery()
 * @method static Builder|SearchRating query()
 * @method static Builder|SearchRating whereCreatedAt($value)
 * @method static Builder|SearchRating whereId($value)
 * @method static Builder|SearchRating whereRating($value)
 * @method static Builder|SearchRating whereRatingableId($value)
 * @method static Builder|SearchRating whereRatingableType($value)
 * @method static Builder|SearchRating whereUpdatedAt($value)
 */
class SearchRating extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ratingable_id',
        'ratingable_type',
        'rating',
    ];

    /**
     * Get the owning ratingable model (e.g. Post, Comment).
     *
     * @return MorphTo
     */
    public function ratingable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @param string $ratingable_type
     * @return SearchRating
     */
    public function setRatingableType(string $ratingable_type): SearchRating
    {
        $this->ratingable_type = $ratingable_type;
        return $this;
    }
}
