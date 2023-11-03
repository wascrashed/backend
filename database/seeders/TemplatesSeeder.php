<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Tbuy\Templates\Models\Templates;

class TemplatesSeeder extends Seeder
{
    public function run(): void
    {
        Templates::factory()->count(10)->create();
    }
}
