<?php

namespace App\Tbuy\ModelInfo\Models;

use App\Tbuy\Search\Model\SearchableField;
use App\Traits\HasAllTranslations;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read int $id
 * @property string $name
 * @property string $slug
 * @property int $model_list_id
 * @property-read Collection<ModelFieldReference> $references
 * @property-read ModelList $model
 * @property-read SearchableField $searchableField
 *
 */
class ModelField extends Model
{
    use HasFactory, HasAllTranslations, SoftDeletes;

    protected $fillable = ['name', 'slug', 'model_list_id'];

    public array $translatable = ['name'];

    public $timestamps = false;

    public function references(): HasMany
    {
        return $this->hasMany(ModelFieldReference::class, 'model_field_id');
    }

    public function model(): BelongsTo
    {
        return $this->belongsTo(ModelList::class, 'model_list_id');
    }

    public function searchableField(): HasOne
    {
        return $this->hasOne(SearchableField::class, 'model_field_id');
    }
}
