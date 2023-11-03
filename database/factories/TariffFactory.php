<?php

namespace Database\Factories;

use App\Tbuy\Tariff\DTOs\PriceDTO;
use App\Tbuy\Tariff\Models\Tariff;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Tariff>
 */
class TariffFactory extends Factory
{
    protected $model = Tariff::class;

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
                'hy' => $this->faker->word
            ],
            'description' => [
                'ru' => $this->faker->text,
                'en' => $this->faker->text,
                'hy' => $this->faker->text
            ],
            'price' => collect([
                new PriceDTO(price: 1000.00, discount_price: null, months: 1),
                new PriceDTO(price: 3000.00, discount_price: 2800.00, months: 3),
                new PriceDTO(price: 6000.00, discount_price: 5000.00, months: 6),
            ]),
            'score' => 100,
            'percent' => 3.5
        ];
    }
}
