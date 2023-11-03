<?php

namespace Database\Seeders;

use App\Tbuy\Bank\Models\BankRatingHistory;
use Illuminate\Database\Seeder;

class BankRatingHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BankRatingHistory::factory(20)->create();
    }
}
