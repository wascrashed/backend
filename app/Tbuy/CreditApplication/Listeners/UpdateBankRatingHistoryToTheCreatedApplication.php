<?php

namespace App\Tbuy\CreditApplication\Listeners;

use App\Tbuy\Bank\Enums\Type;
use App\Tbuy\Bank\Models\Bank;
use App\Tbuy\CreditApplication\Events\SelectedBanksForCreditApplication;
use App\Tbuy\CreditApplication\Models\CreditApplication;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateBankRatingHistoryToTheCreatedApplication implements ShouldQueue
{
    public function handle(SelectedBanksForCreditApplication $event): void
    {
        /**
         * @var CreditApplication $creditApplication
         */
        $creditApplication = CreditApplication::query()->findOrFail($event->creditApplicationId);

        $banks = $creditApplication->banks()->get('id');

        if ($banks->isNotEmpty()) {

            $score = Bank::query()->count() / $banks->count() * 500;

            foreach ($banks as $bank) {
                /**
                 * @var Bank $bank
                 */
                $bank->bankRatingHistories()->create([
                    'type' => Type::CREATED_APPLICATION,
                    'score' => $score,
                ]);
            }
        }
    }
}
