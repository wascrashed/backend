<?php

namespace App\Tbuy\Search\Model;

use App\Tbuy\ModelInfo\Models\ModelList;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read int $id
 * @property int $model_id
 * @property int $priority
 * @property int $count
 * @property-read ModelList $modelList
 * @property-read Collection<SearchableField> $searchableFields
 */
class SearchableModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'searchable_models';

    protected $fillable = [
        'model_id',
        'priority',
        'count',
    ];

    public function modelList(): BelongsTo
    {
        return $this->belongsTo(ModelList::class, 'model_id');
    }

    public function searchableFields(): HasMany
    {
        return $this->hasMany(SearchableField::class, 'searchable_model_id');
    }
}
