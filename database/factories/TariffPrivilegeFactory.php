<?php

namespace Database\Factories;

use App\Tbuy\Tariff\Models\Tariff;
use App\Tbuy\Tariff\Models\TariffPrivilege;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TariffPrivilege>
 */
class TariffPrivilegeFactory extends Factory
{
    protected $model = TariffPrivilege::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => [
                'ru' => $this->faker->sentence(5),
                'en' => $this->faker->sentence(5),
                'hy' => $this->faker->sentence(5),
            ],
            'tariff_id' => Tariff::query()->inRandomOrder()->value('id')
        ];
    }
}
