<?php

namespace App\Tbuy\CreditApplication\Services;

use App\Tbuy\CreditApplication\DTOs\CreditApplicationDTO;
use App\Tbuy\CreditApplication\DTOs\SelectBankForCreditDTO;
use App\Tbuy\CreditApplication\Models\CreditApplication;
use Illuminate\Database\Eloquent\Model;

interface CreditApplicationService
{
    public function selectedBanksForCreditApplication(CreditApplicationDTO $dto): CreditApplication;

    public function selectedBanksWithAnApprovedLoan(SelectBankForCreditDTO $DTO): CreditApplication;
}
