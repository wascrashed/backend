<?php

namespace Tests\Feature\V1\Admin\Target;

use App\Tbuy\Audience\Models\Audience;
use App\Tbuy\Target\Enums\Status;
use App\Tbuy\Target\Models\Target;
use App\Tbuy\User\Repositories\UserRepository;
use Tests\TestCase;

class TargetControllerTest extends TestCase
{
    public function test_index(): void
    {
        $userRepository = $this->app->make(UserRepository::class);
        $user = $userRepository->findById(1);

        $response = $this->actingAs($user)
            ->withHeader('Accept', 'application/json')
            ->get('/api/v1/admin/target');

        $response->assertSuccessful();
    }

    public function test_store(): void
    {
        $userRepository = $this->app->make(UserRepository::class);
        $user = $userRepository->findById(1);
        $audience = Audience::query()->inRandomOrder()->first();

        $data = [
            'audience_id' => $audience->id,
            'targetable_type' => 'product',
            'targetable_id' => 1,
            'name' => [
                'ru' => 'Test 2',
                'en' => 'Test 3',
                'hy' => 'Test 4'
            ],
            'link' => 'http://localhost/',
            'duration' => -5,
            'started_at' => '2023-07-27 14:13:53',
            'finished_at' => '2023-07-27 14:13:53'
        ];
        $response = $this->actingAs($user)
            ->withHeader('Accept', 'application/json')
            ->post('/api/v1/admin/target', $data);

        $response->assertSuccessful();
    }

    public function test_show(): void
    {
        $userRepository = $this->app->make(UserRepository::class);
        $user = $userRepository->findById(1);
        $target = Target::query()->inRandomOrder()->first();

        $response = $this->actingAs($user)
            ->withHeader('Accept', 'application/json')
            ->get("/api/v1/admin/target/$target->id");

        $response->assertSuccessful();
    }

    public function test_update(): void
    {
        $userRepository = $this->app->make(UserRepository::class);
        $user = $userRepository->findById(1);
        $audience = Audience::query()->inRandomOrder()->first();
        $target = Target::query()->inRandomOrder()->first();

        $data = [
            'audience_id' => $audience->id,
            'targetable_type' => 'product',
            'targetable_id' => 1,
            'name' => [
                'ru' => 'Test 2',
                'en' => 'Test 3',
                'hy' => 'Test 4'
            ],
            'link' => 'http://localhost/',
            'duration' => -5,
            'started_at' => '2023-07-27 14:13:53',
            'finished_at' => '2023-07-27 14:13:53'
        ];
        $response = $this->actingAs($user)
            ->withHeader('Accept', 'application/json')
            ->put("/api/v1/admin/target/$target->id", $data);

        $response->assertSuccessful();
    }

    public function test_destroy(): void
    {
        $userRepository = $this->app->make(UserRepository::class);
        $user = $userRepository->findById(1);
        $target = Target::query()->inRandomOrder()->first();

        $response = $this->actingAs($user)
            ->withHeader('Accept', 'application/json')
            ->delete("/api/v1/admin/target/$target->id");

        $response->assertSuccessful();
    }

    public function test_change_status(): void
    {
        $userRepository = $this->app->make(UserRepository::class);
        $user = $userRepository->findById(1);
        $target = Target::query()->inRandomOrder()->first();

        $response = $this->actingAs($user)
            ->withHeader('Accept', 'application/json')
            ->post("/api/v1/admin/target/$target->id/change-status", ['status' => Status::ACCEPTED->value]);

        $response->assertSuccessful();
    }

    public function test_increment_views(): void
    {
        $userRepository = $this->app->make(UserRepository::class);
        $user = $userRepository->findById(1);
        $target = Target::query()->inRandomOrder()->first();

        $response = $this->actingAs($user)
            ->withHeader('Accept', 'application/json')
            ->get("/api/v1/admin/target/$target->id/views/increment");

        $response->assertSuccessful();
    }
}
