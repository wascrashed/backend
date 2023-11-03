<?php

namespace Database\Seeders;

use App\Tbuy\Bank\Models\Bank;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Bank::factory(5)->create();
    }
}
