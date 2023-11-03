<?php

namespace Database\Factories;

use App\Tbuy\Attribute\Models\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Attribute>
 */
class AttributeFactory extends Factory
{
    protected $model = Attribute::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => [
                'ru' => $this->faker->word(),
                'en' => $this->faker->word(),
                'hy' => $this->faker->word()
            ]
        ];
    }
}
