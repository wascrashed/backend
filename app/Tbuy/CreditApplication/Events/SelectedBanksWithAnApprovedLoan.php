<?php

namespace App\Tbuy\CreditApplication\Events;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SelectedBanksWithAnApprovedLoan implements ShouldQueue
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public readonly array $selectedBankIds
    )
    {
    }
}
