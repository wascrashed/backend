<?php

namespace App\Tbuy\Attributable\DTOs;

class ExtendNameDTO
{
    public function __construct(
        public readonly int  $attribute_id,
        public readonly bool $is_name_part = false
    )
    {
    }
}
