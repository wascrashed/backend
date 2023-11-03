<?php

namespace App\Tbuy\Company\SearchRatingCalculations;

use App\Contracts\SearchRatingCalculationContract;
use App\Tbuy\Company\Enums\CompanyType;
use App\Tbuy\Company\Enums\RatingRatio;
use App\Tbuy\Company\Models\Company;
use App\Tbuy\Product\Enums\ProductStatus;
use Illuminate\Database\Eloquent\Model;

class CalculateCompanyDisabledProductsCount implements SearchRatingCalculationContract
{
    public function calculate(Model $model): float|int
    {
        /** @var Company $model */
        $amount = $model->type->isServices()
            ? 0
            : $this->getNotEnoughProductsCount($model);

        return $model->legal_entity
            ? RatingRatio::AMOUNT_DEFICIENCY_LEGAL_ENTITY->calculate($amount)
            : RatingRatio::AMOUNT_DEFICIENCY->calculate($amount);
    }

    private function getNotEnoughProductsCount(Company $company): int
    {
        return $company->products()
            ->where('products.amount', 0)
            ->where('products.active', true)
            ->where('products.status', ProductStatus::CONFIRMED->value)
            ->count();
    }
}
