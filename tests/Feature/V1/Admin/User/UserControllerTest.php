<?php

namespace Tests\Feature\V1\Admin\User;

use App\Tbuy\User\Models\User;
use App\Tbuy\User\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function test_successfully_index(): void
    {
        /** @var User $user */
        $user = User::query()->first();

        $this->actingAs($user)
            ->withHeader('Accept', 'application/json')
            ->getJson(route('api.v1.admin.user.index'))
            ->assertOk()
            ->assertJsonStructure([
                "success",
                "message",
                "data" => [
                    [
                        "id",
                        "name",
                        "email",
                        'balance',
                        "created_at"
                    ],
                ]
            ])
            ->assertJson(
                fn(AssertableJson $json) => $json->where('success', true)->etc()
            );
    }

    public function test_successfully_store(): void
    {
        /** @var User $user */
        $user = User::query()->first();

        $data = User::factory()->raw([
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $this->actingAs($user)
            ->withHeader('Accept', 'application/json')
            ->postJson(route('api.v1.admin.user.store'), $data)
            ->assertCreated()
            ->assertJsonStructure([
                "success",
                "message",
                "data" => [
                    "id",
                    "name",
                    "email",
                    'balance',
                    "created_at"
                ]
            ])
            ->assertJson(
                fn(AssertableJson $json) => $json->where('success', true)->etc()
            );

        $this->assertDatabaseHas('users', [
            'name' => $data['name'],
            'email' => $data['email'],
        ]);
    }

    public function test_fail_store_with_empty_data(): void
    {
        /** @var User $user */
        $user = User::query()->first();

        $data = [];

        $this->actingAs($user)
            ->withHeader('Accept', 'application/json')
            ->postJson(route('api.v1.admin.user.store'), $data)
            ->assertUnprocessable()
            ->assertJsonStructure([
                "message",
                "errors" => [
                    "name",
                    "email",
                    "password",
                ]
            ]);
    }

    public function test_fail_store_without_password_confirmation(): void
    {
        /** @var User $user */
        $user = User::query()->first();

        $data = User::factory()->raw([
            'password' => 'password',
        ]);

        $this->actingAs($user)
            ->withHeader('Accept', 'application/json')
            ->postJson(route('api.v1.admin.user.store'), $data)
            ->assertUnprocessable()
            ->assertJsonStructure([
                "message",
                "errors" => [
                    "password",
                ]
            ]);
    }

    public function test_successfully_show(): void
    {
        /** @var User $user */
        /** @var User $userShow */
        $user = User::query()->first();

        $userShow = User::query()->inRandomOrder()->first();


        $this->actingAs($user)
            ->withHeader('Accept', 'application/json')
            ->getJson(route('api.v1.admin.user.show', $userShow->id))
            ->assertOk()
            ->assertJsonStructure([
                "success",
                "message",
                "data" => [
                    "id",
                    "name",
                    "email",
                    'balance',
                    "created_at"
                ]
            ])
            ->assertJson(
                fn(AssertableJson $json) => $json
                    ->where('success', true)
                    ->where('data.id', $userShow->id)
                    ->where('data.name', $userShow->name)
                    ->where('data.email', $userShow->email)
                    ->etc()
            );
    }

    public function test_successfully_update(): void
    {
        /** @var User $user */
        /** @var User $userUpdate */
        $user = User::query()->first();

        $userUpdate = User::query()->inRandomOrder()->first();

        $data = User::factory()->raw([
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $this->actingAs($user)
            ->withHeader('Accept', 'application/json')
            ->putJson(route('api.v1.admin.user.update', $userUpdate->id), $data)
            ->assertOk()
            ->assertJsonStructure([
                "success",
                "message",
                "data" => [
                    "id",
                    "name",
                    "email",
                    "created_at"
                ]
            ])
            ->assertJson(
                fn(AssertableJson $json) => $json
                    ->where('success', true)
                    ->where('data.id', $userUpdate->id)
                    ->where('data.name', $data['name'])
                    ->where('data.email', $data['email'])
                    ->etc()
            );

        $userUpdate = $userUpdate->fresh();

        $this->assertTrue(Hash::check($data['password'], $userUpdate->password));

        $this->assertDatabaseHas('users', [
            'id' => $userUpdate->id,
            'name' => $data['name'],
            'email' => $data['email']
        ]);
    }

    public function test_fail_update_with_empty_data(): void
    {
        /** @var User $user */
        /** @var User $userUpdate */
        $user = User::query()->first();

        $userUpdate = User::query()->inRandomOrder()->first();

        $data = [];

        $this->actingAs($user)
            ->withHeader('Accept', 'application/json')
            ->putJson(route('api.v1.admin.user.update', $userUpdate->id), $data)
            ->assertUnprocessable()
            ->assertJsonStructure([
                "message",
                "errors" => [
                    "name",
                    "email",
                    "password"
                ]
            ]);
    }

    public function test_fail_update_without_password_confirmation(): void
    {
        /** @var User $user */
        $user = User::query()->first();

        $data = User::factory()->raw([
            'password' => 'password',
        ]);

        $this->actingAs($user)
            ->withHeader('Accept', 'application/json')
            ->putJson(route('api.v1.admin.user.update', $user->id), $data)
            ->assertUnprocessable()
            ->assertJsonStructure([
                "message",
                "errors" => [
                    "password",
                ]
            ]);
    }

    public function test_successfully_destroy(): void
    {
        /** @var User $user */
        /** @var User $userDestroy */
        $user = User::query()->first();

        $userDestroy = User::factory()->create();

        $this->actingAs($user)
            ->withHeader('Accept', 'application/json')
            ->deleteJson(route('api.v1.admin.user.destroy', $userDestroy->id))
            ->assertOk()
            ->assertJsonStructure([
                "success",
                "message"
            ])
            ->assertJson(
                fn(AssertableJson $json) => $json
                    ->where('success', true)
                    ->etc()
            );

        $this->assertSoftDeleted('users', [
            'id' => $userDestroy->id,
        ]);
    }
}
