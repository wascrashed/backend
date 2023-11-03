<?php

namespace Database\Seeders;

use App\Tbuy\ModelInfo\Models\ModelField;
use App\Tbuy\Search\Model\SearchableField;
use App\Tbuy\Search\Model\SearchableModel;
use Illuminate\Database\Seeder;

class SearchableFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modeFields = ModelField::all();

        foreach ($modeFields as $modeField) {
            SearchableField::factory([
                'searchable_model_id' => $modeField->model_list_id,
            ])
                ->for($modeField, 'modelField')
                ->create();
        }
    }
}
