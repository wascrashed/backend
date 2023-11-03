<?php

namespace App\Tbuy\Vacancy\Models;

use App\Tbuy\MediaLibrary\Enums\MediaLibraryCollection;
use App\Traits\HasAllTranslations;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Tags\HasTags;
use Spatie\Tags\Tag;

/**
 * @property-read int $category
 * @property-read string $title
 * @property-read string $description
 * @property-read int $salary
 * @property-read Collection<Tag> $tags
 */
class Vacancy extends Model implements HasMedia
{
    use HasFactory, HasAllTranslations, HasTags, InteractsWithMedia, SoftDeletes;

    public array $translatable = [
        'title',
        'description'
    ];

    protected $fillable = [
        'category_id',
        'title',
        'description',
        'salary'
    ];

    /**
     * Категория вакансии
     *
     * @relationColumn category_id
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(VacancyCategory::class, 'category_id', 'id');
    }

    /**
     * @relationMorphColumn model
     * @return MorphMany
     */
    public function images(): MorphMany
    {
        return $this->morphMany(Media::class, 'model')
            ->where('collection_name', MediaLibraryCollection::VACANCY_MEDIA->value);
    }
}
