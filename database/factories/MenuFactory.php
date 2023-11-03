<?php

namespace Database\Factories;

use App\Tbuy\Menu\Models\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Menu>
 */
class MenuFactory extends Factory
{
    protected $model = Menu::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $word = $this->faker->word,
            'slug' => Str::slug($word),
            'menu_id' => Menu::query()->whereNull('menu_id')->inRandomOrder()->first()?->id,
            'is_active' => $this->faker->boolean
        ];
    }
}
