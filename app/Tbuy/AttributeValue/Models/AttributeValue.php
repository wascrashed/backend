<?php

namespace App\Tbuy\AttributeValue\Models;

use App\Tbuy\Attribute\Models\Attribute;
use App\Tbuy\AttributeValue\Constants\AttributeValueTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\HasAllTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read int $id
 * @property string $name
 * @property int $attribute_id
 * @property Attribute $attribute
 */
class AttributeValue extends Model
{
    use HasFactory, HasAllTranslations, SoftDeletes;

    public array $translatable = ['name'];

    protected $fillable = [
        'name',
        'attribute_id',
        'additional',
        'type'
    ];

    protected $casts = [
        'additional' => 'json',
        'type' => AttributeValueTypeEnum::class
    ];

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }
}
