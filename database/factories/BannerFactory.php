<?php

namespace Database\Factories;

use App\Tbuy\Banner\Models\Banner;
use App\Tbuy\Company\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Banner>
 */
class BannerFactory extends Factory
{
    protected $model = Banner::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => [
                'ru' => $this->faker->word,
                'en' => $this->faker->word,
                'hy' => $this->faker->word,
            ],
            'content' => [
                $this->faker->word => $this->faker->word,
                $this->faker->word => $this->faker->word,
                $this->faker->word => $this->faker->word
            ],
            'company_id' => Company::query()->inRandomOrder()->value('id')
        ];
    }
}
