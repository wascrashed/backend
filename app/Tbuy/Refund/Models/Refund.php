<?php

namespace App\Tbuy\Refund\Models;

use App\Tbuy\Refund\Enums\RefundStatus;
use App\Tbuy\Brand\Models\Brand;
use App\Tbuy\Company\Models\Company;
use App\Tbuy\Purchase\Models\Purchase;
use App\Tbuy\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * @property-read int $id
 * @property-read string $reason
 */
class Refund extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',
        'purchase_id',
        'company_id',
        'brand_id',
        'count',
        'price',
        'status'
    ];

    protected $casts = [
        'status' => RefundStatus::class
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
