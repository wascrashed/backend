<?php

namespace Database\Seeders;

use App\Tbuy\Banner\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Banner::factory(20)->create();
    }
}
