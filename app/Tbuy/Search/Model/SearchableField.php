<?php

namespace App\Tbuy\Search\Model;

use App\Tbuy\ModelInfo\Models\ModelField;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read int $id
 * @property int model_field_id
 * @property int searchable_model_id
 * @property int $priority
 * @property-read ModelField $modelField
 * @property-read SearchableModel $searchableModel
 */
class SearchableField extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'searchable_fields';

    protected $fillable = [
        'model_field_id',
        'searchable_model_id',
        'priority',
    ];

    public function modelField(): BelongsTo
    {
        return $this->belongsTo(ModelField::class, 'model_field_id');
    }

    public function searchableModel(): BelongsTo
    {
        return $this->belongsTo(SearchableModel::class, 'searchable_model_id');
    }
}
