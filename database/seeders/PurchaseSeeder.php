<?php

namespace Database\Seeders;

use App\Tbuy\Purchase\Models\Purchase;
use Illuminate\Database\Seeder;

class PurchaseSeeder extends Seeder
{
    public function run(): void
    {
        Purchase::factory(10)->create();
    }
}
