<?php

namespace App\Tbuy\ModelInfo\Models;

use App\Tbuy\Search\Model\SearchableModel;
use App\Traits\HasAllTranslations;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read int $id
 * @property string $model
 * @property string $label
 * @property string $path
 * @property-read Collection<ModelField> $fields
 * @property-read SearchableModel $searchableModel
 */
class ModelList extends Model
{
    use HasFactory, HasAllTranslations, SoftDeletes;

    protected $fillable = ['model', 'label', 'path'];

    public array $translatable = ['label'];

    public $timestamps = false;

    public function fields(): HasMany
    {
        return $this->hasMany(ModelField::class, 'model_list_id');
    }

    public function references()
    {
        return $this->hasMany(ModelFieldReference::class, 'model_list_id');
    }

    public function searchableModel(): HasOne
    {
        return $this->hasOne(SearchableModel::class, 'model_id');
    }
}
