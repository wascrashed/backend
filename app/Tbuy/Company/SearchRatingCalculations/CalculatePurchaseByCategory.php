<?php

namespace App\Tbuy\Company\SearchRatingCalculations;

use App\Contracts\SearchRatingCalculationContract;
use App\Tbuy\Purchase\Models\ProductPurchase;
use Illuminate\Database\Eloquent\Model;

class CalculatePurchaseByCategory implements SearchRatingCalculationContract
{
    public function calculate(Model $model): float|int
    {
        return ProductPurchase::query()->whereHas('product', function ($query) use ($model) {
            $query->where('category_id', $model->id);
        })->count();
    }
}
