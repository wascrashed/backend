<?php

namespace Database\Factories;

use App\Tbuy\Brand\Models\BrandCategory;
use App\Tbuy\Category\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Tbuy\Brand\Models\Brand;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Model>
 */
class BrandCategoryFactory extends Factory
{
    protected $model = BrandCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $category = Category::query()->inRandomOrder()->first();
        $brand = Brand::query()->inRandomOrder()->first();

        return [
            'category_id' => $category->id,
            'brand_id' => $brand->id
        ];
    }
}
