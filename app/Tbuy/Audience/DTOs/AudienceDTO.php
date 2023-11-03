<?php

namespace App\Tbuy\Audience\DTOs;

class AudienceDTO
{
    public function __construct(
        public readonly ?array  $name,
        public readonly ?int    $company_id,
        public readonly ?int    $country_id,
        public readonly ?int    $region_id,
        public readonly ?string $gender,
        public readonly ?array  $age,
    )
    {
    }
}
