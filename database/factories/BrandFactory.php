<?php

namespace Database\Factories;

use App\Tbuy\Brand\Enums\BrandStatus;
use App\Tbuy\Brand\Models\Brand;
use App\Tbuy\Company\Models\Company;
use App\Tbuy\Country\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Brand>
 */
class BrandFactory extends Factory
{
    protected $model = Brand::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $company = Company::query()->inRandomOrder()->first();
        $country = Country::query()->inRandomOrder()->first();

        return [
            'name' => [
                'ru' => $this->faker->word,
                'en' => $this->faker->word,
                'hy' => $this->faker->word
            ],
            'status' => $this->faker->randomElement(BrandStatus::cases())->value,
            'company_id' => $company->id,
            'country_id' => $country->id,
            'date' => $this->faker->date,
            'description' => [
                'ru' => $this->faker->text,
                'en' => $this->faker->text,
                'hy' => $this->faker->text
            ],
            'accepted_at' => $this->faker->randomElement([null, now()])
        ];
    }
}
