<?php

namespace App\Tbuy\Company\SearchRatingCalculations;

use App\Contracts\SearchRatingCalculationContract;
use App\Tbuy\Company\Enums\RatingRatio;
use App\Tbuy\Company\Models\Company;
use Illuminate\Database\Eloquent\Model;

class CalculateCompanyHasTariff implements SearchRatingCalculationContract
{

    public function calculate(Model $model): float|int
    {
        /** @var Company $model */

        return RatingRatio::HAS_TARIFF->calculate(
            amount: $this->getRatio($model)
        );

    }

    private function getRatio(Company $company): int
    {
        return (int)($this->hasTariff($company) && !$company->legal_entity);
    }

    private function hasTariff(Company $company): bool
    {
        return $company->tariffs()
            ->where('expired_at', '<=', now()->toDateTime())
            ->exists();
    }
}
