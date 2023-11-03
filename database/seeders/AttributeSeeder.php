<?php

namespace Database\Seeders;

use App\Tbuy\Attribute\Models\Attribute;
use App\Tbuy\AttributeValue\Models\AttributeValue;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Attribute::factory(5)->has(AttributeValue::factory(5), 'values')->create();
    }
}
