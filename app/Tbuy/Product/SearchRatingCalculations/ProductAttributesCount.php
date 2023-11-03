<?php

namespace App\Tbuy\Product\SearchRatingCalculations;

use App\Contracts\SearchRatingCalculationContract;
use App\Tbuy\Product\Models\Product;
use Illuminate\Database\Eloquent\Model;

class ProductAttributesCount implements SearchRatingCalculationContract
{
    public function calculate(Model $model): float|int
    {
        /** @var Product $model */
        return $model->attributesList()->count() * 2;
    }
}
