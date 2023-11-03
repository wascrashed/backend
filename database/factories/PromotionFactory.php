<?php

namespace Database\Factories;

use App\Tbuy\Product\Models\Product;
use App\Tbuy\Promotion\Enums\PromotionStatus;
use App\Tbuy\Promotion\Models\Promotion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Promotion>
 */
class PromotionFactory extends Factory
{
    protected $model = Promotion::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = Product::query()->with('brand')->inRandomOrder()->first();

        return [
            'title' => $this->faker->title,
            'discount' => $this->faker->numberBetween(1, 100),
            'status' => $this->faker->randomElement(PromotionStatus::values()),
            'product_id' => $product->id,
            'company_id' => $product->brand->company_id,
        ];
    }
}
