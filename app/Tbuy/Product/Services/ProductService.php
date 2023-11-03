<?php
namespace App\Tbuy\Product\Services;

use App\Tbuy\Product\DTOs\ProductDTO;
use App\Tbuy\Product\DTOs\ProductToggleStatusDTO;
use App\Tbuy\Product\DTOs\ProductUpdateDTO;
use App\Tbuy\Product\DTOs\VisibleFieldsDTO;
use App\Tbuy\Product\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as CollectionAlias;

interface ProductService
{
    public function get(ProductDTO $productDTO, array $with = []): Collection;

    public function update(ProductUpdateDTO $payload, Product $product): Product;

    public function setAttribute(Product $product, CollectionAlias $collection): Product;

    public function getZeroAmount(ProductDTO $productDTO, array $with = []): Collection;

    public function toggleStatus(Product $product, ProductToggleStatusDTO $payload): Product;

    public function extendName(Product $product, CollectionAlias $collection): Product;

}
