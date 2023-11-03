<?php

namespace Database\Factories;

use App\Tbuy\Brand\Models\Brand;
use App\Tbuy\Category\Models\Category;
use App\Tbuy\Product\Enums\ProductType;
use App\Tbuy\Product\Models\Product;
use App\Tbuy\Product\Enums\ProductStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $brand = Brand::query()->inRandomOrder()->first();
        $category = Category::query()->inRandomOrder()->first();
        return [
            'name' => [
                'en' => $this->faker->word,
                'ru' => $this->faker->word,
                'hy' => $this->faker->word
            ],
            'description' => [
                'ru' => $this->faker->text,
                'en' => $this->faker->text,
                'hy' => $this->faker->text
            ],
            'amount' => $this->faker->randomElement([$this->faker->randomNumber(), 0]),
            'active' => $this->faker->boolean,
            'type' => $this->faker->randomElement(ProductType::cases()),
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'color' => $this->faker->hexColor(),
            'size' => $this->faker->randomNumber(),
            'before_declined' => $this->faker->boolean,
            'price' => $this->faker->randomNumber(),
            'accepted_at' => $this->faker->randomElement([null, now()->toDateTimeString()]),
            'status' => $this->faker->randomElement(ProductStatus::values()),
        ];
    }
}
