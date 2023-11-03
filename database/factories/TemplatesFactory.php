<?php

namespace Database\Factories;

use App\Tbuy\Banner\Models\Banner;
use App\Tbuy\Templates\Models\Templates;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Templates>
 */
class TemplatesFactory extends Factory
{
    protected $model = Templates::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => [
                'en' => $this->faker->word,
                'ru' => $this->faker->word,
                'hy' => $this->faker->word
            ],
            'banner_id' => Banner::query()->inRandomOrder()->value('id'),
        ];
    }
}
