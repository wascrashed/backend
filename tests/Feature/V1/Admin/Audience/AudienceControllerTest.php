<?php

namespace Tests\Feature\V1\Admin\Audience;

use App\Tbuy\Audience\Models\Audience;
use App\Tbuy\Company\Models\Company;
use App\Tbuy\Country\Models\Country;
use App\Tbuy\Region\Models\Region;
use App\Tbuy\User\Repositories\UserRepository;
use Tests\TestCase;

class AudienceControllerTest extends TestCase
{
    public function test_index(): void
    {
        $userRepository = $this->app->make(UserRepository::class);
        $user = $userRepository->findById(1);

        $response = $this->actingAs($user)
            ->withHeader('Accept', 'application/json')
            ->get('/api/v1/admin/audience');

        $response->assertSuccessful();
    }

    public function test_store(): void
    {
        $userRepository = $this->app->make(UserRepository::class);
        $user = $userRepository->findById(1);
        $company = Company::query()->inRandomOrder()->first();
        $country = Country::query()->inRandomOrder()->first();
        $region = Region::query()->inRandomOrder()->first();

        $data = [
            'name' => [
                'ru' => 'Test 1',
                'en' => 'Test 1',
                'hy' => 'Test 1'
            ],
            'company_id' => $company->id,
            'country_id' => $country->id,
            'region_id' => $region->id,
            'gender' => 'm',
            'age' => [
                'min' => 20,
                'max' => 30
            ]
        ];
        $response = $this->actingAs($user)
            ->withHeader('Accept', 'application/json')
            ->post('/api/v1/admin/audience', $data);

        $response->assertSuccessful();
    }

    public function test_show(): void
    {
        $userRepository = $this->app->make(UserRepository::class);
        $user = $userRepository->findById(1);
        $audience = Audience::query()->inRandomOrder()->first();

        $response = $this->actingAs($user)
            ->withHeader('Accept', 'application/json')
            ->get("/api/v1/admin/audience/$audience->id");

        $response->assertSuccessful();
    }

    public function test_update(): void
    {
        $userRepository = $this->app->make(UserRepository::class);
        $user = $userRepository->findById(1);
        $audience = Audience::query()->inRandomOrder()->first();
        $company = Company::query()->inRandomOrder()->first();
        $country = Country::query()->inRandomOrder()->first();
        $region = Region::query()->inRandomOrder()->first();

        $data = [
            'name' => [
                'ru' => 'Test 2',
                'en' => 'Test 3',
                'hy' => 'Test 4'
            ],
            'company_id' => $company->id,
            'country_id' => $country->id,
            'region_id' => $region->id,
            'gender' => 'm',
            'age' => [
                'min' => 20,
                'max' => 30
            ]
        ];
        $response = $this->actingAs($user)
            ->withHeader('Accept', 'application/json')
            ->put("/api/v1/admin/audience/$audience->id", $data);

        $response->assertSuccessful();
    }

    public function test_destroy(): void
    {
        $userRepository = $this->app->make(UserRepository::class);
        $user = $userRepository->findById(1);
        $audience = Audience::query()->inRandomOrder()->first();

        $response = $this->actingAs($user)
            ->withHeader('Accept', 'application/json')
            ->delete("/api/v1/admin/audience/$audience->id");

        $response->assertSuccessful();
    }
}
