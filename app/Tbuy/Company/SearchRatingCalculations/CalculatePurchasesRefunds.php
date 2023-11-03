<?php

namespace App\Tbuy\Company\SearchRatingCalculations;

use App\Contracts\SearchRatingCalculationContract;
use App\Tbuy\Company\Enums\RatingRatio;
use App\Tbuy\Company\Models\Company;
use App\Tbuy\Purchase\Models\ProductPurchase;
use App\Tbuy\Refund\Models\Refund;
use Illuminate\Database\Eloquent\Model;

class CalculatePurchasesRefunds implements SearchRatingCalculationContract
{

    public function calculate(Model $model): float|int
    {
        if ($model instanceof Company) {
            $productIds = $model->load('products')->products->pluck('id')->toArray();
            $purchases = ProductPurchase::query()->whereIn('product_id', $productIds)->count();
            $refunds = Refund::query()->whereIn('product_id', $productIds)->count();

            return RatingRatio::PURCHASES_REFUNDS->calculate(($purchases / ($refunds == 0 ? 1 : $refunds)));
        }

        return 0;
    }
}
