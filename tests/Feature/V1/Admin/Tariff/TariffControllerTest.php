<?php

namespace Tests\Feature\V1\Admin\Tariff;

use App\Tbuy\Tariff\Models\Tariff;
use App\Tbuy\Tariff\Models\TariffPrivilege;
use App\Tbuy\User\Models\User;
use App\Tbuy\User\Repositories\UserRepository;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class TariffControllerTest extends TestCase
{
    public function test_successfully_get_list(): void
    {
        /** @var User $user */
        $user = User::query()->first();

        $tariff_count = Tariff::query()->count();

        $this->actingAs($user)
            ->getJson(
                uri: route('api.v1.admin.tariff.index')
            )->assertOk()
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    [
                        'id',
                        'name',
                        'description',
                        'privileges' => [
                            [
                                'name'
                            ]
                        ],
                        'price' => [
                            [
                                'price',
                                'discount_price',
                                'months'
                            ]
                        ],
                        'score',
                        'percent'
                    ]
                ]
            ])->assertJson(
                fn(AssertableJson $json) => $json
                    ->where('success', true)
                    ->has('data', $tariff_count)
                    ->etc()
            );
    }

    public function test_successfully_create_new_tariff(): void
    {
        /** @var User $user */
        $user = User::query()->first();

        $payload = Tariff::factory()->raw([
            'privileges' => TariffPrivilege::factory(3)->raw()
        ]);

        $this->actingAs($user)
            ->postJson(
                uri: route('api.v1.admin.tariff.store'),
                data: $payload
            )->assertCreated()
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'name',
                    'description',
                    'privileges' => [
                        [
                            'name'
                        ]
                    ],
                    'price' => [
                        [
                            'price',
                            'discount_price',
                            'months'
                        ]
                    ],
                    'score',
                    'percent'
                ]
            ])->assertJson(
                fn(AssertableJson $json) => $json
                    ->where('success', true)
                    ->etc()
            );
    }

    public function test_create_tariff_fail_validation_with_empty_parameters(): void
    {
        /** @var User $user */
        $user = User::query()->first();

        $payload = [];

        $this->actingAs($user)
            ->postJson(
                uri: route('api.v1.admin.tariff.store'),
                data: $payload
            )->assertUnprocessable()
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'name.ru',
                    'name.en',
                    'name.hy',
                    'description.ru',
                    'description.en',
                    'description.hy',
                    'price',
                    'score',
                    'percent',
                    'privileges'
                ]
            ]);
    }

    public function test_create_tariff_fail_validation_with_wrong_price(): void
    {
        /** @var User $user */
        $user = User::query()->first();

        $payload = Tariff::factory()->raw([
            'price' => [
                3000
            ],
            'privileges' => TariffPrivilege::factory(3)->raw()
        ]);

        $this->actingAs($user)
            ->postJson(
                uri: route('api.v1.admin.tariff.store'),
                data: $payload
            )->assertUnprocessable()
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'price.0',
                    'price.0.price',
                    'price.0.months',
                ]
            ]);
    }

    public function test_create_tariff_fail_validation_with_wrong_privileges(): void
    {
        /** @var User $user */
        $user = User::query()->first();

        $payload = Tariff::factory()->raw([
            'privileges' => [
                'something-wrong'
            ]
        ]);

        $this->actingAs($user)
            ->postJson(
                uri: route('api.v1.admin.tariff.store'),
                data: $payload
            )->assertUnprocessable()
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'privileges.0',
                    'privileges.0.name',
                    'privileges.0.name.ru',
                    'privileges.0.name.en',
                    'privileges.0.name.hy',
                ]
            ]);
    }

    public function test_show(): void
    {
        /** @var User $user */
        $user = User::query()->first();

        $tariff_id = Tariff::query()->inRandomOrder()->value('id');

        $this->actingAs($user)
            ->getJson(
                uri: route('api.v1.admin.tariff.show', $tariff_id)
            )->assertOk()
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'name',
                    'description',
                    'privileges' => [
                        [
                            'name'
                        ]
                    ],
                    'price' => [
                        [
                            'price',
                            'discount_price',
                            'months'
                        ]
                    ],
                    'score',
                    'percent'
                ]
            ])->assertJson(
                fn(AssertableJson $json) => $json
                    ->where('success', true)
                    ->where('data.id', $tariff_id)
                    ->etc()
            );

    }

    public function test_successfully_update_tariff(): void
    {
        /** @var User $user */
        $user = User::query()->first();
        $tariff_id = Tariff::query()->inRandomOrder()->value('id');

        $payload = Tariff::factory()->raw([
            'privileges' => TariffPrivilege::factory(3)->raw()
        ]);

        $this->actingAs($user)
            ->putJson(
                uri: route('api.v1.admin.tariff.update', $tariff_id),
                data: $payload
            )->assertOk()
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'name',
                    'description',
                    'privileges' => [
                        [
                            'name'
                        ]
                    ],
                    'price' => [
                        [
                            'price',
                            'discount_price',
                            'months'
                        ]
                    ],
                    'score',
                    'percent'
                ]
            ])->assertJson(
                fn(AssertableJson $json) => $json
                    ->where('success', true)
                    ->where('data.id', $tariff_id)
                    ->where('data.name', $payload['name']['ru'])
                    ->where('data.description', $payload['description']['ru'])
                    ->where('data.score', $payload['score'])
                    ->where('data.percent', $payload['percent'])
                    ->has('data.price', $payload['price']->count())
                    ->etc()
            );
    }

    public function test_update_tariff_fail_validation_with_empty_parameters(): void
    {
        /** @var User $user */
        $user = User::query()->first();
        $tariff_id = Tariff::query()->inRandomOrder()->value('id');

        $payload = [];

        $this->actingAs($user)
            ->putJson(
                uri: route('api.v1.admin.tariff.update', $tariff_id),
                data: $payload
            )->assertUnprocessable()
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'name.ru',
                    'name.en',
                    'name.hy',
                    'description.ru',
                    'description.en',
                    'description.hy',
                    'price',
                    'score',
                    'percent',
                    'privileges'
                ]
            ]);
    }

    public function test_update_tariff_fail_validation_with_wrong_price(): void
    {
        /** @var User $user */
        $user = User::query()->first();
        $tariff_id = Tariff::query()->inRandomOrder()->value('id');

        $payload = Tariff::factory()->raw([
            'price' => [
                3000
            ],
            'privileges' => TariffPrivilege::factory(3)->raw()
        ]);

        $this->actingAs($user)
            ->putJson(
                uri: route('api.v1.admin.tariff.update', $tariff_id),
                data: $payload
            )->assertUnprocessable()
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'price.0',
                    'price.0.price',
                    'price.0.months',
                ]
            ]);
    }

    public function test_update_tariff_fail_validation_with_wrong_privileges(): void
    {
        /** @var User $user */
        $user = User::query()->first();
        $tariff_id = Tariff::query()->inRandomOrder()->value('id');

        $payload = Tariff::factory()->raw([
            'privileges' => [
                'something-wrong'
            ]
        ]);

        $this->actingAs($user)
            ->putJson(
                uri: route('api.v1.admin.tariff.update', $tariff_id),
                data: $payload
            )->assertUnprocessable()
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'privileges.0',
                    'privileges.0.name',
                    'privileges.0.name.ru',
                    'privileges.0.name.en',
                    'privileges.0.name.hy',
                ]
            ]);
    }

    public function test_successfully_destroy(): void
    {
        $userRepository = $this->app->make(UserRepository::class);
        $user = $userRepository->findById(1);
        $tariff_id = Tariff::query()->inRandomOrder()->value('id');

        $this->actingAs($user)
            ->deleteJson(
                uri: route('api.v1.admin.tariff.destroy', $tariff_id)
            )->assertJsonStructure([
                'success',
                'message'
            ])->assertJson(
                fn(AssertableJson $json) => $json
                    ->where('success', true)
                    ->where('message', 'Тариф удален')
                    ->etc()
            );

        $this->assertSoftDeleted('tariffs', [
            'id' => $tariff_id,
        ]);
    }
}
