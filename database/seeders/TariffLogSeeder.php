<?php

namespace Database\Seeders;

use App\Tbuy\Tariff\Models\TariffLog;
use Illuminate\Database\Seeder;

class TariffLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TariffLog::factory(10)->create();
    }
}
