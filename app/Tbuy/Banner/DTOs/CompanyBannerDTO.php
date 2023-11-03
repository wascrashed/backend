<?php

namespace App\Tbuy\Banner\DTOs;

use App\DTOs\BaseDTO;

class CompanyBannerDTO extends BaseDTO
{
    public function __construct(
        public readonly ?int $company_id = null,
        public readonly ?int $banner_id = null,
        public readonly ?int $activated_at = null,
        public readonly ?int $deactivated_at = null
    )
    {
    }
}
