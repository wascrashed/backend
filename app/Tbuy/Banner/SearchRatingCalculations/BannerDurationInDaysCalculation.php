<?php

namespace App\Tbuy\Banner\SearchRatingCalculations;

use App\Contracts\SearchRatingCalculationContract;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

class BannerDurationInDaysCalculation implements SearchRatingCalculationContract
{
    public function calculate(Model $model): float|int
    {
        return $model->target->reduce(function ($days, $item) {
            $started_at = new Carbon($item->target->started_at);
            $finished_at = new Carbon($item->target->finished_at);
            $diffInDays = $finished_at->diffInDays($started_at) ?? 0;

            return $days + $diffInDays;
        }, 0);
    }
}
