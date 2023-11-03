<?php

namespace App\Tbuy\Company\SearchRatingCalculations;

use App\Contracts\SearchRatingCalculationContract;
use App\Tbuy\Company\Enums\CompanyType;
use App\Tbuy\Company\Models\Company;
use Illuminate\Database\Eloquent\Model;

class CompanySubscribersCountCalculation implements SearchRatingCalculationContract
{
    public function calculate(Model $model): float|int
    {
        /**
         * @var Company $model
         */
        $subscribersCount = $model->subscribers()->count();

        if ($model->legal_entity) { // connect to task-84 legal_entity is not done yet
            // если это юридическое лицо
            $score = match ($model->type->value) {
                CompanyType::SALES->value => $subscribersCount * 20,
                CompanyType::SERVICES->value => $subscribersCount * 500,
            };
        } else {
            // если это физическое лицо
            $score = $subscribersCount * 200;
        }

        return $score;
    }
}
