<?php

namespace App\Tbuy\Company\SearchRatingCalculations;

use App\Contracts\SearchRatingCalculationContract;
use App\Tbuy\Company\Enums\CompanyType;
use App\Tbuy\Company\Models\Company;
use App\Tbuy\Complaint\Models\Complaint;
use App\Tbuy\Product\Enums\RatingRatio;
use Illuminate\Database\Eloquent\Model;

class CalculateComplaints implements SearchRatingCalculationContract
{

    public function calculate(Model $model): float|int
    {
        /** @var Company $model */
        $complaintsCount = $model->complaints()->count();

        if ($model->legal_entity) {
            $score = $model->type === CompanyType::SERVICES->value
                ? RatingRatio::SERVICE_COMPLAINT_ENTITY->calculate($complaintsCount)
                : RatingRatio::PRODUCT_COMPLAINT_ENTITY->calculate($complaintsCount);
        } else {
            $score = RatingRatio::COMPLAINT_INDIVIDUAL->calculate($complaintsCount);
        }

        return $score;
    }
}
