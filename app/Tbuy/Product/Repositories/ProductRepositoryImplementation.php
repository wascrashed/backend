<?php

namespace App\Tbuy\Product\Repositories;

use App\Tbuy\Product\DTOs\ProductDTO;
use App\Tbuy\Product\DTOs\ProductToggleStatusDTO;
use App\Tbuy\Product\DTOs\ProductUpdateDTO;
use App\Tbuy\Product\Enums\ProductStatus;
use App\Tbuy\Product\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductRepositoryImplementation implements ProductRepository
{
    public function update(ProductUpdateDTO $productUpdateDTO, Product $product): Product
    {
        $product->update(array_filter((array)$productUpdateDTO) + ['status' => ProductStatus::WAITING]);

        return $product->load(['category', 'brand.company', 'images']);
    }

    public function toggleStatus(ProductToggleStatusDTO $productToggleStatusDTO, Product $product): Product
    {
        $product->fill([
            'status' => $productToggleStatusDTO->status
        ]);

        if ($productToggleStatusDTO->status === ProductStatus::CONFIRMED) {
            $product->fill([
                'accepted_at' => now()
            ]);
        }

        $product->save();

        return $product->load(['category', 'brand.company', 'images']);
    }

    public function getZeroAmount(ProductDTO $productDTO, array $with = []): Collection
    {
        return Product::query()
            ->with($with)
            ->zeroAmount()
            ->filter($productDTO)
            ->get();
    }

    public function get(ProductDTO $productDTO, array $with = []): Collection
    {
        $product = Product::query()
            ->with($with)
            ->filter($productDTO);

        if ($productDTO->zero_amount) {
            $product = $product->zeroAmount();
        }

        return $product->get();
    }
}
