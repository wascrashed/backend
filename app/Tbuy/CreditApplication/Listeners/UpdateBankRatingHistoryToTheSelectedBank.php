<?php

namespace App\Tbuy\CreditApplication\Listeners;

use App\Tbuy\Bank\Enums\Type;
use App\Tbuy\Bank\Models\Bank;
use App\Tbuy\Bank\Models\BankRatingHistory;
use App\Tbuy\CreditApplication\Enums\Status;
use App\Tbuy\CreditApplication\Events\SelectedBankWithAnApprovedLoanByUser;
use App\Tbuy\CreditApplication\Models\CreditApplication;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateBankRatingHistoryToTheSelectedBank implements ShouldQueue
{
    public function handle(SelectedBankWithAnApprovedLoanByUser $event): void
    {
        /**
         * @var CreditApplication $creditApplication
         * @var Bank $selectedBank
         */
        $creditApplication = CreditApplication::query()->findOrFail($event->creditApplicationId);
        $score = 0;
        $banksCount = $creditApplication->banks()
            ->where('status', '!=', Status::SELECTED->value)
            ->count();
        $selectedBank = $creditApplication->selectedBank()->firstOrFail();

        if ($banksCount > 1) {
            $score = $banksCount * 200;
        }

        $selectedBank->bankRatingHistories()->create([
            'type' => Type::SELECTED_APPLICATION,
            'score' => $score,
        ]);
    }
}
