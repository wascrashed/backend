<?php

namespace App\Tbuy\Product\Calculations;

use App\Contracts\SearchRatingCalculationContract;
use App\Tbuy\Product\Enums\ProductType;
use App\Tbuy\Product\Models\Product;
use Illuminate\Database\Eloquent\Model;

class CountGiftCardsByCompanies implements SearchRatingCalculationContract
{
    public function calculate(Model $model): int
    {
        return Product::query()->where('company_id', $model->id)
            ->where('type', ProductType::GIFT_CARD->value)
            ->count();
    }
}
