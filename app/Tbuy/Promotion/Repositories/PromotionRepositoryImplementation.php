<?php

namespace App\Tbuy\Promotion\Repositories;

use App\Tbuy\Company\Models\Company;
use App\Tbuy\Promotion\Models\Promotion;
use App\Tbuy\Product\Models\Product;
use Carbon\Carbon;

class PromotionRepositoryImplementation implements PromotionRepository
{
    public function hasActivePromotion(Product $product): bool
    {
        return Promotion::where('product_id', $product->id)
            ->where('active', true)
            ->where('start_date', '<=', Carbon::now())
            ->where('end_date', '>=', Carbon::now())
            ->exists();
    }
}
