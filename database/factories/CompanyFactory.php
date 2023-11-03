<?php

namespace Database\Factories;

use App\Tbuy\Company\Enums\CompanyStatus;
use App\Tbuy\Company\Enums\CompanyType;
use App\Tbuy\Company\Models\Company;
use App\Tbuy\User\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Company>
 */
class CompanyFactory extends Factory
{
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::query()->inRandomOrder()->first();

        return [
            'name' => [
                'ru' => $this->faker->word,
                'en' => $this->faker->word,
                'hy' => $this->faker->word
            ],
            'legal_name_company' => $this->faker->word,
            'type' => $this->faker->randomElement(CompanyType::cases()),
            'inn' => $this->faker->numberBetween(1000000, 99999999),
            'company_address' => $this->faker->word,
            'director' => [
                'last_name' => $this->faker->lastName,
                'first_name' => $this->faker->firstName
            ],
            'email' => $this->faker->email,
            'registered_at' => $this->faker->dateTime,
            'status' => $this->faker->randomElement(CompanyStatus::cases()),
            'user_id' => $user->id,
            'slug' => $this->faker->unique()->slug,
            'legal_entity' => $this->faker->boolean
        ];
    }
}
