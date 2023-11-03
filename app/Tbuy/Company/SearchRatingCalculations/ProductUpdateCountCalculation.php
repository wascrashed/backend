<?php

namespace App\Tbuy\Company\SearchRatingCalculations;

use App\Contracts\SearchRatingCalculationContract;
use Illuminate\Database\Eloquent\Model;

class ProductUpdateCountCalculation implements SearchRatingCalculationContract
{

    public function calculate(Model $model): float|int
    {
        $score = $model->products()->sum('update_count');

        $score *= $model->legal_entity ? 8 : 50;

        return $score;
    }
}
