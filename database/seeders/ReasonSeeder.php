<?php

namespace Database\Seeders;

use App\Tbuy\Reason\Models\Reason;
use Illuminate\Database\Seeder;

class ReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Reason::factory(5)->create();
    }
}
