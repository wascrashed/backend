<?php

namespace Database\Seeders;

use App\Tbuy\ModelInfo\Models\ModelList;
use App\Tbuy\Search\Model\SearchableModel;
use Illuminate\Database\Seeder;

class SearchableModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modelLists = ModelList::all();

        foreach ($modelLists as $modelList) {
            SearchableModel::factory()
                ->for($modelList, 'modelList')
                ->create();
        }
    }
}
