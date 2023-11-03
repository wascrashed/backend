<?php

namespace App\Tbuy\Bank\SearchRatingsCalculation;

use App\Contracts\SearchRatingCalculationContract;
use App\Tbuy\Bank\Enums\Type;
use App\Tbuy\Bank\Models\Bank;
use Illuminate\Database\Eloquent\Model;

class SelectedBankSearchRatingCalculation implements SearchRatingCalculationContract
{
    public function calculate(Model $model): float|int
    {
        /**
         * @var Bank $model
         */
        return $model->bankRatingHistories()
            ->where('type', Type::SELECTED_APPLICATION->value)
            ->sum('score');
    }
}
