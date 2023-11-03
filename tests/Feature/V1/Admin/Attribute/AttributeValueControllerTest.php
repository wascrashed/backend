<?php

namespace Tests\Feature\V1\Admin\Attribute;

use App\Tbuy\AttributeValue\Models\AttributeValue;
use App\Tbuy\User\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AttributeValueControllerTest extends TestCase
{
    public function test_successfully_create_new_attribute_value(): void
    {
        /** @var User $user */
        $user = User::query()->first();

        $payload = AttributeValue::factory()->raw();

        $this->actingAs($user)
            ->postJson(
                uri: route('api.v1.admin.attribute_value.store'),
                data: $payload
            )->assertCreated()
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'name',
                    'attribute' => [
                        'id',
                        'name'
                    ]
                ]
            ])->assertJson(
                fn(AssertableJson $json) => $json
                    ->where('success', true)
                    ->where('data.name', $payload['name']['ru'])
                    ->etc()
            );
    }

    public function test_fail_create_new_attribute_value_with_empty_parameters(): void
    {
        /** @var User $user */
        $user = User::query()->first();

        $payload = [];

        $this->actingAs($user)
            ->postJson(
                uri: route('api.v1.admin.attribute_value.store'),
                data: $payload
            )->assertUnprocessable()
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'name.ru',
                    'name.en',
                    'name.hy',
                    'attribute_id',
                ]
            ]);
    }

    public function test_successfully_update_attribute_value(): void
    {
        /** @var User $user */
        $user = User::query()->first();
        $value_id = AttributeValue::query()->inRandomOrder()->value('id');

        $payload = AttributeValue::factory()->raw();

        $this->actingAs($user)
            ->putJson(
                uri: route('api.v1.admin.attribute_value.update', $value_id),
                data: $payload
            )->assertOk()
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'name',
                    'attribute' => [
                        'id',
                        'name'
                    ]
                ]
            ])->assertJson(
                fn(AssertableJson $json) => $json
                    ->where('success', true)
                    ->where('data.id', $value_id)
                    ->where('data.name', $payload['name']['ru'])
                    ->etc()
            );
    }

    public function test_fail_update_attribute_value_with_empty_parameters(): void
    {
        /** @var User $user */
        $user = User::query()->first();
        $value_id = AttributeValue::query()->inRandomOrder()->value('id');

        $payload = [];

        $this->actingAs($user)
            ->putJson(
                uri: route('api.v1.admin.attribute_value.update', $value_id),
                data: $payload
            )->assertUnprocessable()
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'name.ru',
                    'name.en',
                    'name.hy',
                    'attribute_id',
                ]
            ]);
    }
}
