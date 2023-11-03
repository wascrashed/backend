<?php

namespace App\Tbuy\AttributeValue\DTOs;

class AttributeValueDTO
{
    public function __construct(
        public readonly array $name,
        public readonly int   $attribute_id
    )
    {
    }
}
