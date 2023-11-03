<?php

namespace App\Tbuy\Company\DTOs;

use App\DTOs\BaseDTO;
use Carbon\Carbon;

/**
 * Поля для подтверждения компании
 *
 * @param string $bank_account банковский счет компании
 * @param Carbon $tariff_conditions_accepted_at дата принятия основного соглашения
 * @param Carbon $basic_agreement_accepted_at дата принятия условий стандартного тарифного плана
 */
class CompanyDataConfirmationDTO extends BaseDTO
{
    public Carbon $tariff_conditions_accepted_at;
    public Carbon $basic_agreement_accepted_at;

    public function __construct(
        public string $bank_account,
        string        $tariff_conditions_accepted_at,
        string        $basic_agreement_accepted_at
    )
    {
        $this->tariff_conditions_accepted_at = Carbon::parse($tariff_conditions_accepted_at);
        $this->basic_agreement_accepted_at = Carbon::parse($basic_agreement_accepted_at);
    }
}
