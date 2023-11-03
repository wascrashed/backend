<?php

namespace Database\Factories;

use App\Tbuy\Attributable\Models\Attributable;
use App\Tbuy\Attribute\Models\Attribute;
use App\Tbuy\AttributeValue\Models\AttributeValue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Attributable>
 */
class AttributableFactory extends Factory
{
    protected $model = Attributable::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $attribute = Attribute::query()->with('values')->inRandomOrder()->first();
        /** @var Collection<AttributeValue> $values */
        $values = $attribute->values;


        return [
            'attribute_id' => $attribute->id,
            'attribute_value_id' => $values->shuffle()->first()->id
        ];
    }
}
