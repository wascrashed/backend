<?php

namespace App\Tbuy\Banner\DTOs;

use App\DTOs\BaseDTO;

class BannerDTO extends BaseDTO
{
    public function __construct(
        public readonly array $name,
        public readonly array $content,
        public readonly int   $company_id
    )
    {
    }
}
