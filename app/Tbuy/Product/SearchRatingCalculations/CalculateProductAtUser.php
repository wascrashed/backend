<?php

namespace App\Tbuy\Product\SearchRatingCalculations;

use App\Contracts\SearchRatingCalculationContract;
use App\Tbuy\User\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CalculateProductAtUser implements SearchRatingCalculationContract
{

    public function calculate(Model $model): float|int
    {
        return $model->baskets()->count() * 4;
    }
}
