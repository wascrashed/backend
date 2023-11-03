<?php

namespace Database\Seeders;

use App\Tbuy\Filial\Models\Filial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FilialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Filial::factory(10)->create();
    }
}
