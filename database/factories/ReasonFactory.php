<?php

namespace Database\Factories;

use App\Tbuy\Reason\Models\Reason;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Reason>
 */
class ReasonFactory extends Factory
{
    protected $model = Reason::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'reason' => [
                'ru' =>  $this->faker->text(),
                'en' =>  $this->faker->text(),
                'hy' =>  $this->faker->text(),
            ],
        ];
    }
}
