<?php

namespace Database\Seeders;

use App\Tbuy\Basket\Models\Basket;
use Illuminate\Database\Seeder;

class BasketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Basket::factory(100)->create();
    }
}
