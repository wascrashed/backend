<?php

namespace App\Tbuy\Bank\SearchRatingsCalculation;

use App\Contracts\SearchRatingCalculationContract;
use App\Tbuy\Bank\Models\Bank;
use App\Tbuy\CreditApplication\Enums\Status;
use App\Tbuy\CreditApplication\Models\CreditApplication;
use Illuminate\Database\Eloquent\Model;

class BankCreatedAndRejectedApplicationsRatioSearchRatingCalculation implements SearchRatingCalculationContract
{
    public function calculate(Model $model): float|int
    {
        /**
         * @var Bank $model
         */
        $totalApplications = $model->creditApplications()->count();
        $totalRejections = $model->rejectedCreditApplications()->count();

        return !$totalRejections ? 0 : $totalApplications / $totalRejections * 1000;
    }
}
