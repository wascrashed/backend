<?php

namespace Database\Factories;

use App\Tbuy\Question\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Question>
 */
class QuestionFactory extends Factory
{
    protected $model = Question::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'question' => [
                'ru' => $this->faker->text(),
                'en' => $this->faker->text(),
                'hy' => $this->faker->text()
            ],
            'answer' => [
                'ru' => $this->faker->text(),
                'en' => $this->faker->text(),
                'hy' => $this->faker->text()
            ],
        ];
    }
}
