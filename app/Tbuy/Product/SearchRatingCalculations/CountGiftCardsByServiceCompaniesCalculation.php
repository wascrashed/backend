<?php

namespace App\Tbuy\Product\SearchRatingCalculations;

use App\Contracts\SearchRatingCalculationContract;
use App\Tbuy\Company\Enums\CompanyType;
use App\Tbuy\Company\Models\Company;
use App\Tbuy\Product\Enums\ProductType;
use Illuminate\Database\Eloquent\Model;

class CountGiftCardsByServiceCompaniesCalculation implements SearchRatingCalculationContract
{

    public function calculate(Model $model): float|int
    {
        /** @var Company $model */

        return Company::query()->where('type', CompanyType::SERVICES->value)
            ->with(['products' => fn($builder) => $builder
                ->where('type', ProductType::GIFT_CARD->value)])
            ->get()->count();
    }
}
