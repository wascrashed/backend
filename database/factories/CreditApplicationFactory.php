<?php

namespace Database\Factories;

use App\Tbuy\Bank\Models\Bank;
use App\Tbuy\CreditApplication\Enums\Status;
use App\Tbuy\CreditApplication\Models\CreditApplication;
use App\Tbuy\User\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Credit application
 * @extends Factory<CreditApplication>
 */
class CreditApplicationFactory extends Factory
{
    protected $model = CreditApplication::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::query()->inRandomOrder()->first()?->id,
            'status' => $this->faker->randomElement(Status::cases()),
            'requested_sum' => $this->faker->randomNumber(),
        ];
    }
}
