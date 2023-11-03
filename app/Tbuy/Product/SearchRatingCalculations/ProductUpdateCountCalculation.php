<?php

namespace App\Tbuy\Product\SearchRatingCalculations;

use App\Contracts\SearchRatingCalculationContract;
use Illuminate\Database\Eloquent\Model;

class ProductUpdateCountCalculation implements SearchRatingCalculationContract
{

    public function calculate(Model $model): float|int
    {
        return $model->update_count * 10;
    }
}
