<?php

namespace App\Tbuy\Product\SearchRatingCalculations;

use App\Contracts\SearchRatingCalculationContract;
use App\Tbuy\Product\Models\Product;
use App\Tbuy\Promotion\Enums\PromotionStatus;
use Illuminate\Database\Eloquent\Model;

class CountInactivePromotionForProduct implements SearchRatingCalculationContract
{
    public function calculate(Model $model): int
    {
        /** @var Product $model */
        return $model->promotions()
            ->where('status', PromotionStatus::INACTIVE)
            ->count() * 3;
    }
}
