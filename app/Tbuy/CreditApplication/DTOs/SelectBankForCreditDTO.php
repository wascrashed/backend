<?php

namespace App\Tbuy\CreditApplication\DTOs;

use App\Tbuy\Bank\Models\Bank;
use App\Tbuy\CreditApplication\Models\CreditApplication;

class SelectBankForCreditDTO
{
    public function __construct(
        public readonly Bank $bank,
        public readonly CreditApplication $creditApplication,
    )
    {
    }
}
