<?php

namespace Database\Factories;

use App\Tbuy\Vacancy\Models\VacancyCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class VacancyCategoryFactory extends Factory
{
    public $model = VacancyCategory::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->title()
        ];
    }
}
