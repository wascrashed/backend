<?php

namespace App\Tbuy\Company\SearchRatingCalculations;

use App\Contracts\SearchRatingCalculationContract;
use App\Tbuy\Purchase\Models\ProductPurchase;
use Illuminate\Database\Eloquent\Model;

class ProductPurchasesCountCalculation implements SearchRatingCalculationContract
{

    public function calculate(Model $model): float|int
    {
        $productsCompany = $model->products()->get();
        $score = ProductPurchase::whereIn('product_id', $productsCompany->pluck('id'))->count();

        $score *= $model->legal_entity ? 10 : 100;

        return $score;
    }
}
