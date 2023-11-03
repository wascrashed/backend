<?php

namespace Database\Factories;

use App\Tbuy\Complaint\Models\Complaint;
use App\Tbuy\User\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Complaint>
 */
class ComplaintFactory extends Factory
{
    protected $model = Complaint::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'complaint' => $this->faker->text,
            'lang' => $this->faker->languageCode,
            'user_id' => User::query()->inRandomOrder()->first()->id
        ];
    }
}
