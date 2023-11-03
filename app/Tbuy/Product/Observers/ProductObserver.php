<?php

namespace App\Tbuy\Product\Observers;

use App\Tbuy\Product\Models\Product;

class ProductObserver
{
    public function updating(Product $product): void
    {
        $product->update_count = $product->update_count + 1;
    }
}
