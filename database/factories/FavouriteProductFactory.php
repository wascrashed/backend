<?php

namespace Database\Factories;

use App\Tbuy\FavouriteProduct\Models\FavouriteProduct;
use App\Tbuy\Product\Models\Product;
use App\Tbuy\User\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FavouriteProduct>
 */
class FavouriteProductFactory extends Factory
{
    protected $model = FavouriteProduct::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::query()->inRandomOrder()->first()->id,
            'user_id' => User::query()->inRandomOrder()->first()->id,
        ];
    }
}
