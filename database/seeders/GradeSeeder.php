<?php

namespace Database\Seeders;

use App\Tbuy\Grade\Models\Grade;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Grade::factory()->count(5)->create();
    }
}
