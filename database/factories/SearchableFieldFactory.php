<?php

namespace Database\Factories;

use App\Tbuy\ModelInfo\Models\ModelField;
use App\Tbuy\Search\Model\SearchableField;
use App\Tbuy\Search\Model\SearchableModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SearchableField>
 */
class SearchableFieldFactory extends Factory
{
    protected $model = SearchableField::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $modelField = ModelField::query()->inRandomOrder()->first();
        $searchableModel = SearchableModel::query()->inRandomOrder()->first();

        return [
            'model_field_id' => $modelField->id,
            'searchable_model_id' => $searchableModel->id,
            'priority' => $this->faker->randomNumber(),
        ];
    }
}
