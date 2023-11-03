<?php

namespace App\Tbuy\Tariff\DTOs;

use App\DTOs\BaseDTO;

class TariffPrivilegeDTO extends BaseDTO
{
    public function __construct(
        public readonly array $name
    )
    {
    }
}
