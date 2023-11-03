<?php

namespace Database\Seeders;

use App\Tbuy\Region\Models\Region;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Region::factory(10)->create();
    }
}
