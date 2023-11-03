<?php

namespace Database\Factories;

use App\Tbuy\Basket\Models\Basket;
use App\Tbuy\Product\Models\Product;
use App\Tbuy\User\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Basket>
 */
class BasketFactory extends Factory
{
    protected $model = Basket::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = Product::query()->inRandomOrder()->first();

        return [
            'user_id' => User::query()->inRandomOrder()->first()->id,
            'product_id' => $product->id,
            'amount' => $this->randomAmount($product)
        ];
    }

    protected function randomAmount(Product $product): int
    {
        $num = $this->faker->randomNumber();

        if ($num > $product->amount) {
            $this->randomAmount($product);
        }

        return $num;
    }
}
