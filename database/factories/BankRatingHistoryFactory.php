<?php

namespace Database\Factories;

use App\Tbuy\Bank\Enums\Type;
use App\Tbuy\Bank\Models\Bank;
use App\Tbuy\Bank\Models\BankRatingHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

class BankRatingHistoryFactory extends Factory
{
    protected $model = BankRatingHistory::class;

    public function definition(): array
    {
        return [
            'bank_id' => Bank::query()->inRandomOrder()->first()?->id,
            'score' => $this->faker->randomNumber(),
            'type' => $this->faker->randomElement(Type::cases()),
        ];
    }
}
