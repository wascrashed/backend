<?php

namespace App\Tbuy\Attributable\Models;

use App\Tbuy\Attribute\Models\Attribute;
use App\Tbuy\AttributeValue\Models\AttributeValue;
use App\Tbuy\Brand\Models\Brand;
use App\Tbuy\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read int $id
 * @property string $attributable_type
 * @property int $attributable_id
 * @property int $attribute_id
 * @property int $attribute_value_id
 * @property bool $is_name_part
 * @property int $order
 * @property-read Attribute $attribute
 * @property-read AttributeValue $value
 * @property-read Brand|Product $attributable
 */
class Attributable extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'attributable';

    protected $fillable = [
        'attributable_type',
        'attributable_id',
        'attribute_id',
        'attribute_value_id',
        'is_name_part',
        'order'
    ];

    protected $casts = [
        'is_name_part' => 'boolean'
    ];

    public function attributable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @relationColumn attribute_id
     * @return BelongsTo
     */
    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

    /**
     * @relationColumn attribute_value_id
     * @return BelongsTo
     */
    public function value(): BelongsTo
    {
        return $this->belongsTo(AttributeValue::class, 'attribute_value_id');
    }
}
