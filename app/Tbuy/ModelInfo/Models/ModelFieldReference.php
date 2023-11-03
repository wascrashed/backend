<?php

namespace App\Tbuy\ModelInfo\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read int $id
 * @property int $model_field_id
 * @property int $foreign_model_field_id
 * @property string $relation_type
 * @property-read ModelField $field
 */
class ModelFieldReference extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'model_field_id',
        'foreign_model_field_id',
        'relation_type'
    ];

    public $timestamps = false;

    public function field(): BelongsTo
    {
        return $this->belongsTo(ModelField::class, 'model_field_id');
    }
}
