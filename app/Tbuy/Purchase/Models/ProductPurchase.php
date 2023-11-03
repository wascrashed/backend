<?php

namespace App\Tbuy\Purchase\Models;

use App\Tbuy\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $product_id
 * @property int $purchase_id
 * @property int $count
 * @property int $price
 * @property-read Product $product
 * @property-read Purchase $purchase
 */
class ProductPurchase extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'product_purchase';

    protected $fillable = [
        'product_id',
        'purchase_id',
        'count',
        'price',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class, 'purchase_id', 'id');
    }
}
