<?php

namespace App\Tbuy\Product\Repositories;

use App\Tbuy\Product\DTOs\ProductDTO;
use App\Tbuy\Product\DTOs\VisibleFieldsDTO;
use App\Tbuy\Product\DTOs\ProductToggleStatusDTO;
use App\Tbuy\Product\DTOs\ProductUpdateDTO;
use App\Tbuy\Product\Models\Product;
use Illuminate\Database\Eloquent\Collection;

interface ProductRepository
{
    public function get(ProductDTO $productDTO, array $with = []): Collection;

    public function update(ProductUpdateDTO $productUpdateDTO, Product $product): Product;

    public function toggleStatus(ProductToggleStatusDTO $productToggleStatusDTO, Product $product): Product;

    public function getZeroAmount(ProductDTO $productDTO, array $with = []): Collection;
}
