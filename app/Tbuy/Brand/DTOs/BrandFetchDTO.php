<?php

namespace App\Tbuy\Brand\DTOs;

class BrandFetchDTO
{
    public function __construct(
        public readonly ?string $date = null,
        public readonly ?int    $company = null,
        public readonly ?int    $category = null,
        public readonly ?string $status = null,
        public readonly ?int    $reason_id = null,
        public readonly ?int    $brand_id = null
    )
    {
    }
}
