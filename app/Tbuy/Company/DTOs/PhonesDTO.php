<?php

namespace App\Tbuy\Company\DTOs;

use App\DTOs\BaseDTO;

class PhonesDTO extends BaseDTO
{
    public function __construct(
        public readonly ?string $phone_director = null,
        public readonly ?string $phone_sales_department = null,
        public readonly ?string $phone_marketing_department = null,
        public readonly ?string $phone_operator = null,
        public readonly ?string $phone_viber = null,
        public readonly ?string $phone_whatsapp = null,
        public readonly ?string $phone_telegram = null,
    )
    {
    }
}
