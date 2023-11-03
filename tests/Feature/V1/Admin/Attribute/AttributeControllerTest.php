<?php

namespace Tests\Feature\V1\Admin\Attribute;

use App\Tbuy\Attribute\Models\Attribute;
use App\Tbuy\User\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AttributeControllerTest extends TestCase
{
    public function test_successfully_create_new_attribute(): void
    {
        /** @var User $user */
        $user = User::query()->first();

        $payload = Attribute::factory()->raw();

        $this->actingAs($user)
            ->postJson(
                uri: route('api.v1.admin.attribute.store'),
                data: $payload
            )->assertCreated()
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'name'
                ]
            ])
            ->assertJson(
                fn(AssertableJson $json) => $json
                    ->where('success', true)
                    ->where('data.name', $payload['name']['ru'])
                    ->etc()
            );
    }

    public function test_fail_create_new_attribute_with_empty_parameters()
    {
        /** @var User $user */
        $user = User::query()->first();

        $payload = [];

        $this->actingAs($user)
            ->postJson(
                uri: route('api.v1.admin.attribute.store'),
                data: $payload
            )
            ->assertUnprocessable()
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'name.ru',
                    'name.en',
                    'name.hy'
                ]
            ]);
    }

    public function test_successfully_update_attribute()
    {
        /** @var User $user */
        $user = User::query()->first();
        $attribute_id = Attribute::query()->inRandomOrder()->value('id');


        $payload = Attribute::factory()->raw();

        $this->actingAs($user)
            ->putJson(
                uri: route('api.v1.admin.attribute.update', $attribute_id),
                data: $payload
            )->assertOk()
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'name'
                ]
            ])
            ->assertJson(
                fn(AssertableJson $json) => $json
                    ->where('success', true)
                    ->where('data.name', $payload['name']['ru'])
                    ->where('data.id', $attribute_id)
                    ->etc()
            );
    }

    public function test_fail_update_attribute_with_empty_parameters()
    {
        /** @var User $user */
        $user = User::query()->first();
        $attribute_id = Attribute::query()->inRandomOrder()->value('id');

        $payload = [];

        $this->actingAs($user)
            ->putJson(
                uri: route('api.v1.admin.attribute.update', $attribute_id),
                data: $payload
            )
            ->assertUnprocessable()
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'name.ru',
                    'name.en',
                    'name.hy'
                ]
            ]);
    }

    public function test_successfully_delete()
    {
        $this->assertTrue(true);
    }
}
