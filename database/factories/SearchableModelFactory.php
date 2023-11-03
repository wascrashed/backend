<?php

namespace Database\Factories;

use App\Tbuy\ModelInfo\Models\ModelList;
use App\Tbuy\Search\Model\SearchableModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SearchableModel>
 */
class SearchableModelFactory extends Factory
{
    protected $model = SearchableModel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $model = ModelList::query()->inRandomOrder()->first();

        return [
            'model_id' => $model->id,
            'priority' => $this->faker->randomNumber(2),
            'count' => $this->faker->randomNumber(),
        ];
    }
}
