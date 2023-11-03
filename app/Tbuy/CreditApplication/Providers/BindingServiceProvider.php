<?php

namespace App\Tbuy\CreditApplication\Providers;

use App\Contracts\SearchRatingCalculationContract;
use App\Tbuy\Bank\SearchRatingsCalculation\SelectedBankForApplicationSearchRatingCalculation;
use Illuminate\Support\ServiceProvider;

class BindingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
//        $this->app->bind(SearchRatingCalculationContract::class, AllBanksAndSelectedBanksToApplyForALoan::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
