<?php

namespace Database\Seeders;

use App\Tbuy\Purchase\Models\ProductPurchase;
use Illuminate\Database\Seeder;

class ProductPurchaseSeeder extends Seeder
{
    public function run(): void
    {
        ProductPurchase::factory(50)->create();
    }
}
