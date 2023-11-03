<?php

namespace App\Tbuy\Company\SearchRatingCalculations;

use App\Contracts\SearchRatingCalculationContract;
use App\Tbuy\Company\Models\Company;
use Illuminate\Database\Eloquent\Model;

class CalculatePromotionsCount implements SearchRatingCalculationContract
{

    public function calculate(Model $model): float|int
    {
        /** @var Company $model */

        return $model->promotions()->count();
    }
}
