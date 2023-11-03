<?php

namespace Database\Seeders;

use App\Tbuy\Target\Models\Target;
use Illuminate\Database\Seeder;

class TargetSeeder extends Seeder
{
    public function run(): void
    {
        Target::factory(10)->create();
    }
}
