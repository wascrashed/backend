<?php

namespace App\Tbuy\Company\SearchRatingCalculations;

use App\Contracts\SearchRatingCalculationContract;
use App\Tbuy\Company\Enums\CompanyType;
use App\Tbuy\Company\Enums\RatingRatio;
use App\Tbuy\Company\Models\Company;
use Illuminate\Database\Eloquent\Model;

class CalculateSocialEntriesCount implements SearchRatingCalculationContract
{
    public function calculate(Model $model): float|int
    {
        /** @var Company $model */

        $entries_count = $model->socialEntries()->count();

        return !$model->legal_entity
            ? RatingRatio::SOCIAL_ENTRY->calculate($entries_count)
            : (
            $model->type->value === CompanyType::SERVICES->value
                ? RatingRatio::SOCIAL_ENTRY_LEGAL_ENTITY_SERVICES->calculate($entries_count)
                : RatingRatio::SOCIAL_ENTRY_LEGAL_ENTITY_SALES->calculate($entries_count)
            );
    }
}
