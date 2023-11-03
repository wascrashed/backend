<?php

namespace Database\Factories;

use App\Tbuy\Company\Models\Company;
use App\Tbuy\Employee\Models\CompanyEmployee;
use App\Tbuy\User\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyEmployeeFactory extends Factory
{
    protected $model = CompanyEmployee::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::query()->inRandomOrder()->first();
        $company = Company::query()->inRandomOrder()->first();

        return [
            'user_id' => $user->id,
            'company_id' => $company->id,
            'username' => $this->faker->unique()->userName,
            'password' => bcrypt('password'),
        ];
    }
}
