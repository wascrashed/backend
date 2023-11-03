<?php

namespace Database\Seeders;

use App\Tbuy\Employee\Models\CompanyEmployee;
use Illuminate\Database\Seeder;

class CompanyEmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CompanyEmployee::factory(100)->create();
    }
}
