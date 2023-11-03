<?php

namespace App\Tbuy\Category\SearchRatingCalculations;

use App\Contracts\SearchRatingCalculationContract;
use App\Tbuy\Category\Models\Category;
use Illuminate\Database\Eloquent\Model;

class CalculateChildLevel implements SearchRatingCalculationContract
{

    public function calculate(Model $model): float|int
    {
        if ($model instanceof Category) {
            $category = $model->loadMissing('grandParent');

            return $this->incrementRatio($category->grandParent, 1);
        }

        return 0;
    }

    private function incrementRatio(?Category $grandParent, int $ratio): int
    {
        if (!$grandParent) {
            return $ratio;
        }

        return $this->incrementRatio($grandParent->grandParent, $ratio + 1);
    }
}
