<?php

namespace App\Tbuy\Brand\SearchRatingCalculations;

use App\Contracts\SearchRatingCalculationContract;
use App\Tbuy\Purchase\Models\ProductPurchase;
use Illuminate\Database\Eloquent\Model;

class ProductPurchasesCountCalculation implements SearchRatingCalculationContract
{

    public function calculate(Model $model): float|int
    {
        $productsBrand = $model->products()->get();
        $score = ProductPurchase::whereIn('product_id', $productsBrand->pluck('id'))->count();

        return $score * 500;
    }
}
