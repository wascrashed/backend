<?php

namespace Database\Factories;

use App\Enums\MorphType;
use App\Tbuy\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Overtrue\LaravelFavorite\Favorite;

/**
 * @extends Factory<Favorite>
 */
class FavoriteFactory extends Factory
{
    protected $model = Favorite::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = Product::query()->inRandomOrder()->first();

        return [
            'favoriteable_type' => MorphType::getType(Product::class),
            'favoriteable_id' => $product->id
        ];
    }
}
