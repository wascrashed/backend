<?php

namespace App\Tbuy\Product\Calculations;

use App\Tbuy\Product\Models\Product;

class CountCommentsTheProduct
{
    public function calculate(Product $product): int
    {
        return $product->comments()->count();
    }
}
