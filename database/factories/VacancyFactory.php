<?php

namespace Database\Factories;

use App\Tbuy\Vacancy\Models\Vacancy;
use Illuminate\Database\Eloquent\Factories\Factory;

class VacancyFactory extends Factory
{
    public $model = Vacancy::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->title(),
            'description' => $this->faker->text(),
            'salary' => $this->faker->numberBetween(100, 100000)
        ];
    }
}
