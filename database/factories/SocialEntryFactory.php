<?php

namespace Database\Factories;

use App\Enums\MorphType;
use App\Tbuy\Socials\Constants\SocialEntryTypeEnum;
use App\Tbuy\Socials\Models\SocialEntry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SocialEntry>
 */
class SocialEntryFactory extends Factory
{
    protected $model = SocialEntry::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $socialable = $this->faker->randomElement(SocialEntryTypeEnum::cases());
        $model = $socialable->value::query()->inRandomOrder()->first();
        $model_type = MorphType::getType($socialable->value);

        return [
            'social_name' => $this->faker->word,
            'socialable_id' => $model->id,
            'socialable_type' => $model_type,
        ];
    }
}
