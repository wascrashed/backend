<?php

namespace App\Tbuy\Attributable\DTOs;

use App\DTOs\BaseDTO;

class AttributableDTO extends BaseDTO
{
    public function __construct(
        public readonly int  $attribute_id,
        public readonly int  $attribute_value_id,
        public readonly bool $is_name_part
    )
    {
    }
}
