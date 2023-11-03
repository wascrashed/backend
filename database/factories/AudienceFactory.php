<?php

namespace Database\Factories;

use App\Tbuy\Audience\Enums\Gender;
use App\Tbuy\Audience\Models\Audience;
use App\Tbuy\Company\Models\Company;
use App\Tbuy\Country\Models\Country;
use App\Tbuy\Region\Models\Region;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AudienceFactory extends Factory
{
    protected $model = Audience::class;

    public function definition(): array
    {
        $company = Company::query()->inRandomOrder()->first();
        $country = Country::query()->inRandomOrder()->first();
        $region = Region::query()->inRandomOrder()->first();

        return [
            'name' => $this->faker->name(),
            'company_id' => $company->id,
            'country_id' => $country->id,
            'region_id' => $region->id,
            'gender' => $this->faker->randomElement(Gender::cases())->value,
            'age' => [
                'min' => $this->faker->randomNumber(),
                'max' => $this->faker->randomNumber()
            ],
        ];
    }
}
