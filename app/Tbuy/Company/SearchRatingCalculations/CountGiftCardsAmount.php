<?php

namespace App\Tbuy\Company\SearchRatingCalculations;

use App\Contracts\SearchRatingCalculationContract;
use App\Tbuy\Company\Models\Company;
use App\Tbuy\Product\Enums\ProductStatus;
use App\Tbuy\Product\Enums\ProductType;
use Illuminate\Database\Eloquent\Model;

class CountGiftCardsAmount implements SearchRatingCalculationContract
{

    public function calculate(Model $model): float|int
    {
        /** @var Company $model */

        return $model->type->isServices()
            ? $this->getGiftCardsCount($model)
            : 0;
    }

    private function getGiftCardsCount(Company $company): int
    {
        return $company->products()
            ->where('products.type', '=', ProductType::GIFT_CARD->value)
            ->where('products.status', '=', ProductStatus::CONFIRMED->value)
            ->where('products.active', '=', true)
            ->count();
    }
}
