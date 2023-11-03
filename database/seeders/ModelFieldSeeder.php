<?php

namespace Database\Seeders;

use App\Tbuy\ModelInfo\Models\ModelField;
use App\Tbuy\ModelInfo\Models\ModelList;
use Illuminate\Database\Seeder;

class ModelFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $model = ModelList::query()
            ->doesntHave('fields')
            ->get()
            ->each(function (ModelList $model) {
                $modelObject = app($model->model);
                $columns = $modelObject->getFillable();

                $prepareColumns = array_map(
                    fn(string $column) => [
                        'name' => json_encode([
                            'ru' => $column,
                            'en' => $column,
                            'hy' => $column,
                        ]),
                        'slug' => $column,
                        'model_list_id' => $model->id
                    ],
                    $columns);

                ModelField::query()->insert($prepareColumns);

            });

    }
}
