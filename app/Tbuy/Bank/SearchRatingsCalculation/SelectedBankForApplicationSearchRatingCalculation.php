<?php

namespace App\Tbuy\Bank\SearchRatingsCalculation;

use App\Contracts\SearchRatingCalculationContract;
use App\Tbuy\Bank\Enums\Type;
use Illuminate\Database\Eloquent\Model;

class SelectedBankForApplicationSearchRatingCalculation implements SearchRatingCalculationContract
{
    public function calculate(Model $model): float|int
    {
        return $model->bankRatingHistories()
            ->where('type', Type::CREATED_APPLICATION->value)
            ->sum('score');
    }
}
