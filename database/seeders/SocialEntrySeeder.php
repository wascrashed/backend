<?php

namespace Database\Seeders;

use App\Tbuy\Socials\Models\SocialEntry;
use Illuminate\Database\Seeder;

class SocialEntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SocialEntry::factory(100)->create();
    }
}
