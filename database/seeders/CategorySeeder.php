<?php

namespace Database\Seeders;

use App\Tbuy\Category\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::factory(5)
            ->has(
                Category::factory(5)
                    ->has(Category::factory(5), 'children'),
                'children'
            )
            ->create();
    }
}
