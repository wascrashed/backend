<?php

namespace Database\Factories;

use App\Tbuy\Grade\Models\Grade;
use App\Tbuy\Product\Models\Product;
use App\Tbuy\User\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class GradeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Grade::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'user_id' => User::query()->inRandomOrder()->first()->id,
            'product_id' => Product::query()->inRandomOrder()->first()->id,
            'grade' => $this->faker->numberBetween(1, 4),
        ];
    }
}
