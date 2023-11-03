<?php

namespace App\Tbuy\Tariff\DTOs;

use App\DTOs\BaseDTO;

class TariffLogFilterDTO extends BaseDTO
{
    public function __construct(
        public readonly ?int $user_id = null,
        public readonly ?int $tariff_id = null,
        public readonly ?int $company_id = null
    )
    {
    }
}
