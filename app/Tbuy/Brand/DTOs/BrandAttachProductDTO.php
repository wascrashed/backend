<?php

namespace App\Tbuy\Brand\DTOs;

class BrandAttachProductDTO
{
    public function __construct(
        public readonly array $product
    )
    {
    }
}
