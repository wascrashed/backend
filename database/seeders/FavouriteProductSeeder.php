<?php

namespace Database\Seeders;

use App\Tbuy\FavouriteProduct\Models\FavouriteProduct;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FavouriteProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FavouriteProduct::factory(100)->create();
    }
}
