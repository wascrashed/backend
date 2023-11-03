<?php

namespace App\Tbuy\Product\SearchRatingCalculations;

use App\Contracts\SearchRatingCalculationContract;
use Illuminate\Database\Eloquent\Model;

class ProductViewCount implements SearchRatingCalculationContract
{
    public function calculate(Model $model): float|int
    {
        return $model->views * 2;
    }
}
