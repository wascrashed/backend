<?php

namespace App\Tbuy\Promotion\Services;

use App\Tbuy\Company\Models\Company;
use App\Tbuy\Product\Models\Product;

interface PromotionService
{
    public function hasActivePromotion(Product $product): bool;
}
