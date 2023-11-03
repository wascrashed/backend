<?php

namespace App\Tbuy\Product\DTOs;

use App\Tbuy\Product\Enums\ProductType;

class ProductUpdateDTO
{
    public readonly ?ProductType $type;

    public function __construct(
        public readonly int              $category_id,
        public readonly array            $description,
        public readonly VisibleFieldsDTO $visible_fields,
        public ?array                    $images = null,
        public readonly ?float           $amount = null,
        public readonly ?float           $price = null,
        public readonly ?bool            $active = null,
        public readonly ?int             $brand_id = null,
        ?string                          $type = null,
    )
    {
        $this->type = $type ? ProductType::from($type) : null;
    }
}
