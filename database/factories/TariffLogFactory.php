<?php

namespace Database\Factories;

use App\Tbuy\Company\Models\Company;
use App\Tbuy\Tariff\Models\Tariff;
use App\Tbuy\Tariff\Models\TariffLog;
use App\Tbuy\User\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TariffLog>
 */
class TariffLogFactory extends Factory
{
    protected $model = TariffLog::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::query()->inRandomOrder()->first()->id,
            'company_id' => Company::query()->inRandomOrder()->first()->id,
            'tariff_id' => Tariff::query()->inRandomOrder()->first()->id,
            'months' => mt_rand(1, 3),
            'price' => $this->faker->randomElement([40000, 240000, 420000])
        ];
    }
}
