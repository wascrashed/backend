<?php

namespace App\Tbuy\Product\Enums;

use App\Tbuy\Product\DTOs\ProductDTO;
use App\Traits\SetKeys;

enum ProductCacheKey: string
{
    use SetKeys;

    case LIST = 'product-list';
    case ZERO_LIST = 'product-zero-list';

    public static function ttl(): int
    {
        return 3_600 * 24; // 24 hours
    }

    public function withProductDtoKeys(ProductDTO $productDTO): string
    {
        return $this->value . implode('-', [
                $productDTO->name,
                $productDTO->before_declined,
                $productDTO->id,
                $productDTO->to,
                $productDTO->from,
                $productDTO->category_id,
                $productDTO->active,
                $productDTO->status?->value,
                $productDTO->limit,
                $productDTO->orderDirection
        ]);
    }
}
