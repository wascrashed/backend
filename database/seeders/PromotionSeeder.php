<?php

namespace Database\Seeders;

use App\Tbuy\Promotion\Models\Promotion;
use Illuminate\Database\Seeder;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Promotion::factory(100)->create();
    }
}
