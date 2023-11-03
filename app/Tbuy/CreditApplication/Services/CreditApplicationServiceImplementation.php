<?php

namespace App\Tbuy\CreditApplication\Services;

use App\Tbuy\CreditApplication\DTOs\CreditApplicationDTO;
use App\Tbuy\CreditApplication\DTOs\SelectBankForCreditDTO;
use App\Tbuy\CreditApplication\Enums\Status;
use App\Tbuy\CreditApplication\Events\SelectedBanksForCreditApplication;
use App\Tbuy\CreditApplication\Events\SelectedBankWithAnApprovedLoanByUser;
use App\Tbuy\CreditApplication\Models\CreditApplication;

class CreditApplicationServiceImplementation implements CreditApplicationService
{
    public function selectedBanksForCreditApplication(CreditApplicationDTO $dto): CreditApplication
    {
        /**
         * @var CreditApplication $creditApplication
         */
        $creditApplication = CreditApplication::query()->create([
            'user_id' => $dto->userId,
            'requested_sum' => $dto->sum,
        ]);

        foreach ($dto->bankIds as $bankId) {
            $creditApplication->banks()->attach($bankId, [
                'sum' => $dto->sum,
            ]);
        }

        event(new SelectedBanksForCreditApplication($creditApplication->id));

        return $creditApplication;
    }

    public function selectedBanksWithAnApprovedLoan(SelectBankForCreditDTO $DTO): CreditApplication
    {
        if (!$DTO->creditApplication->selectedBank()->exists()) {
            $DTO->creditApplication->banks()->updateExistingPivot($DTO->bank->id, ['status' => Status::SELECTED]);

            event(new SelectedBankWithAnApprovedLoanByUser($DTO->creditApplication->id));
        }
        return $DTO->creditApplication;
    }
}
