<?php

namespace App\Tbuy\Product\SearchRatingCalculations;

use App\Contracts\SearchRatingCalculationContract;
use App\Tbuy\Company\Enums\RatingRatio;
use App\Tbuy\Promotion\Models\Promotion;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CalculateHasActivePromotion implements SearchRatingCalculationContract
{

    public function calculate(Model $model): float|int
    {
        $hasPromotion = Promotion::query()->where('product_id', '=', $model->id)->where('active', true)
            ->where('start_date', '<=', Carbon::now())
            ->where('end_date', '>=', Carbon::now())
            ->exists();

        return RatingRatio::HAS_PROMOTION->calculate($hasPromotion);
    }
}
