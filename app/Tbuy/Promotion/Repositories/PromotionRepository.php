<?php

namespace App\Tbuy\Promotion\Repositories;

use App\Tbuy\Company\Models\Company;
use App\Tbuy\Product\Models\Product;

interface PromotionRepository
{
    public function hasActivePromotion(Product $product): bool;
}
