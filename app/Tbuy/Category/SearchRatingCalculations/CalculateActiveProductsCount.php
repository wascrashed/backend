<?php

namespace App\Tbuy\Category\SearchRatingCalculations;

use App\Contracts\SearchRatingCalculationContract;
use App\Tbuy\Category\Models\Category;
use Illuminate\Database\Eloquent\Model;

class CalculateActiveProductsCount implements SearchRatingCalculationContract
{

    public function calculate(Model $model): float|int
    {
        /** @var Category $model */

        return $model->products()->where('active', '=', true)->count();
    }
}
