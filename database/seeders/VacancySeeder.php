<?php

namespace Database\Seeders;

use App\Tbuy\Vacancy\Models\Vacancy;
use App\Tbuy\Vacancy\Models\VacancyCategory;
use Illuminate\Database\Seeder;

class VacancySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vacancyCategories = VacancyCategory::factory(5)->create();

        Vacancy::factory(5)
            ->for($vacancyCategories->random(), 'category')
            ->create();
    }
}
