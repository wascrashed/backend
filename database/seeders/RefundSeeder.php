<?php

namespace Database\Seeders;

use App\Tbuy\Refund\Models\Refund;
use Illuminate\Database\Seeder;

class RefundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Refund::factory(10)->create();
    }
}
