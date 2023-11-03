<?php

namespace App\Tbuy\Company\DTOs;

use App\DTOs\BaseDTO;
use App\Tbuy\Company\Enums\CompanyStatus;

class CompanyFilterDTO extends BaseDTO
{
    public function __construct(
        public readonly ?CompanyStatus $status = null,
        public readonly bool $parent = false
    )
    {
    }
}
