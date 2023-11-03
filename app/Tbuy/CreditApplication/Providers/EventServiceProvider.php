<?php

namespace App\Tbuy\CreditApplication\Providers;

use App\Tbuy\CreditApplication\Events\SelectedBanksForCreditApplication;
use App\Tbuy\CreditApplication\Events\SelectedBankWithAnApprovedLoanByUser;
use App\Tbuy\CreditApplication\Listeners\UpdateBankRatingHistoryToTheCreatedApplication;
use App\Tbuy\CreditApplication\Listeners\UpdateBankRatingHistoryToTheSelectedBank;
use App\Tbuy\CreditApplication\Listeners\UpdateBankRatingHistoryWithTheMostProfitableLoan;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        SelectedBanksForCreditApplication::class => [
            UpdateBankRatingHistoryToTheCreatedApplication::class,
        ],
        SelectedBankWithAnApprovedLoanByUser::class => [
            UpdateBankRatingHistoryToTheSelectedBank::class,
            UpdateBankRatingHistoryWithTheMostProfitableLoan::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }
}
