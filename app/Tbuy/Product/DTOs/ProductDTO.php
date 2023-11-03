<?php

namespace App\Tbuy\Product\DTOs;

use App\Tbuy\Product\Enums\ProductStatus;

class ProductDTO
{
    public null|ProductStatus $status = null;

    public function __construct(
        public readonly ?string $from = null,
        public readonly ?string  $to = null,
        public readonly ?string  $name = null,
        public readonly ?int  $id = null,
        public readonly ?int  $category_id = null,
        public readonly ?bool  $before_declined = null,
        string  $status = null,
        public readonly ?bool $active = null,
        public readonly ?int $limit = null,
        public readonly ?string $orderDirection = null,
        public readonly ?bool $zero_amount = null,
        public readonly ?int $reason_id = null,
        public readonly ?bool $before_accepted = null,
        public readonly ?bool $before_declined_reasons = null
    ) {
        $this->status = !is_null($status) ? ProductStatus::from($status) : null;
    }
}
