<?php

namespace App\Tbuy\Promotion\Models;

use App\Tbuy\Company\Models\Company;
use App\Tbuy\Product\Models\Product;
use App\Tbuy\Promotion\Enums\PromotionStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property-read int $id
 * @property-read string $title
 * @property-read int $discount
 * @property-read int $product_id
 * @property-read int $company_id
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * @property-read Product $product
 * @property-read Company $company
 * @method static Builder|Promotion query()
 */
class Promotion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'discount',
        'product_id',
        'company_id',
        'status'
    ];

    protected $casts = [
        'status' => PromotionStatus::class,
    ];

    /**
     * @relationColumn product_id
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    /**
     * @relationColumn company_id
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
}
