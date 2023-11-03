<?php

namespace App\Tbuy\FavouriteProduct\Observers;

use App\Tbuy\FavouriteProduct\Models\FavouriteProduct;

class FavouriteProductObserver
{
    public function creating(FavouriteProduct $product)
    {
        $product->created_at = now();
    }
}
