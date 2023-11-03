<?php

namespace Database\Factories;

use App\Tbuy\Brand\Models\Brand;
use App\Tbuy\Purchase\Models\Purchase;
use App\Tbuy\User\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseFactory extends Factory
{
    protected $model = Purchase::class;

    public function definition(): array
    {
        $user = User::query()->inRandomOrder()->first();
        $brand = Brand::query()->inRandomOrder()->first();

        return [
            'user_id' => $user->id,
            'brand_id' => $brand->id,
            'total_sum' => $this->faker->randomNumber()
        ];
    }
}
