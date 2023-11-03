<?php

namespace Database\Seeders;

use App\Tbuy\Audience\Models\Audience;
use Illuminate\Database\Seeder;

class AudienceSeeder extends Seeder
{
    public function run(): void
    {
        Audience::factory(10)->create();
    }
}
