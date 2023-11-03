<?php

namespace App\Tbuy\Promotion\Services;

use App\Tbuy\Company\Models\Company;
use App\Tbuy\Product\Models\Product;
use App\Tbuy\Promotion\Repositories\PromotionRepository;

class PromotionServiceImplementation implements PromotionService
{
    public function __construct(
        private readonly PromotionRepository $promotionRepository
    )
    {
    }

    public function hasActivePromotion(Product $product): bool
    {
        return $this->promotionRepository->hasActivePromotion($product);
    }
}
