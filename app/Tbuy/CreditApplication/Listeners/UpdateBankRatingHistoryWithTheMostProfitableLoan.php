<?php

namespace App\Tbuy\CreditApplication\Listeners;

use App\Tbuy\Bank\Enums\Type;
use App\Tbuy\Bank\Models\Bank;
use App\Tbuy\Bank\Models\BankRatingHistory;
use App\Tbuy\CreditApplication\Enums\Status;
use App\Tbuy\CreditApplication\Events\SelectedBankWithAnApprovedLoanByUser;
use App\Tbuy\CreditApplication\Models\CreditApplication;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateBankRatingHistoryWithTheMostProfitableLoan implements ShouldQueue
{
    public function handle(SelectedBankWithAnApprovedLoanByUser $event): void
    {
        /**
         * @var CreditApplication $creditApplication
         * @var Bank $profitableBank
         */
        $creditApplication = CreditApplication::query()->findOrFail($event->creditApplicationId);
        $profitableBank = $creditApplication->acceptedAndProfitableBank()->firstOrFail();
        $selectedBank = $creditApplication->selectedBank()->firstOrFail();
        $score = 0;

        if ($selectedBank->isNot($profitableBank) && $creditApplication->banks()->where('status', Status::ACCEPTED->value)->count() + 1 > 1) {
            $score = $selectedBank->pivot->sum / $profitableBank->pivot->sum * 100;
        }

        $profitableBank->bankRatingHistories()->create([
            'type' => Type::PROFITABLE_LOAN,
            'score' => $score,
        ]);
    }
}
