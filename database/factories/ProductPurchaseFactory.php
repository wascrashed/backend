<?php

namespace Database\Factories;

use App\Tbuy\Product\Models\Product;
use App\Tbuy\Purchase\Models\ProductPurchase;
use App\Tbuy\Purchase\Models\Purchase;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductPurchaseFactory extends Factory
{
    protected $model = ProductPurchase::class;

    public function definition(): array
    {
        $product = Product::query()->inRandomOrder()->first();
        $purchase = Purchase::query()->inRandomOrder()->first();

        return [
            'product_id' => $product->id,
            'purchase_id' => $purchase->id,
            'count' => $this->faker->randomNumber(),
            'price' => $this->faker->randomNumber(),
        ];
    }
}
