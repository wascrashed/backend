<?php

namespace App\Tbuy\Brand\DTOs;

use Illuminate\Http\UploadedFile;

class BrandDTO
{
    public function __construct(
        public readonly array  $name,
        public readonly array  $description,
        public readonly int    $country_id,
        public readonly int    $company_id,
        public readonly string $date,
        public ?UploadedFile   $logo = null,
        public ?UploadedFile   $certificate = null
    )
    {
    }
}
