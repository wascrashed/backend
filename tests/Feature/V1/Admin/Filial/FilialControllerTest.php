<?php

namespace Tests\Feature\V1\Admin\Filial;

use App\Tbuy\Company\Models\Company;
use App\Tbuy\Filial\Models\Filial;
use App\Tbuy\User\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class FilialControllerTest extends TestCase
{
    public function test_successfully_create_new_filial(): void
    {
        /**
         * @var User $user
         * @var Company $company
         */
        $user = User::query()->first();
        $company = Company::query()
            ->inRandomOrder()
            ->whereHas('filials')
            ->first();

        $payload = Filial::factory()->raw();

        $this->actingAs($user)
            ->postJson(
                uri: route('api.v1.client.company.filial.store', $company->id),
                data: $payload
            )->assertCreated()
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'name',
                    'phone',
                    'address',
                    'coordinates' => [
                        'latitude',
                        'longitude'
                    ],
                    'schedule' => [
                        [
                            'open_at',
                            'close_at',
                            'day',
                            'day_string'
                        ]
                    ],
                    'is_main',
                    'community' => [
                        'id'
                    ],
                    'region' => [
                        'id'
                    ]
                ]
            ])->assertJson(
                fn(AssertableJson $json) => $json
                    ->where('success', true)
                    ->etc()
            );
    }

    public function test_fail_create_new_filial_with_empty_parameters(): void
    {
        /**
         * @var User $user
         * @var Company $company
         */
        $user = User::query()->first();
        $company = Company::query()
            ->inRandomOrder()
            ->whereHas('filials')
            ->first();

        $payload = [];

        $this->actingAs($user)
            ->postJson(
                uri: route('api.v1.client.company.filial.store', $company->id),
                data: $payload
            )->assertUnprocessable()
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'name.en',
                    'name.ru',
                    'name.hy',
                    'phone',
                    'address',
                    'schedule',
                    'coordinates.latitude',
                    'coordinates.longitude',
                    'is_main',
                    'community_id',
                    'region_id',
                ]
            ]);
    }

    public function test_successfully_update_filial(): void
    {
        /**
         * @var User $user
         * @var Company $company
         */
        $user = User::query()->first();
        $company = Company::query()
            ->inRandomOrder()
            ->with('filials')
            ->whereHas('filials')
            ->first();

        $filial_id = $company->filials->random(1)->first()->id;

        $payload = Filial::factory()->raw();

        $this->actingAs($user)
            ->putJson(
                uri: route('api.v1.client.company.filial.update', [$company->id, $filial_id]),
                data: $payload
            )->assertOk()
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'name',
                    'phone',
                    'address',
                    'coordinates' => [
                        'latitude',
                        'longitude'
                    ],
                    'schedule' => [
                        [
                            'open_at',
                            'close_at',
                            'day',
                            'day_string'
                        ]
                    ],
                    'is_main',
                    'community' => [
                        'id'
                    ],
                    'region' => [
                        'id'
                    ]
                ]
            ])->assertJson(
                fn(AssertableJson $json) => $json
                    ->where('success', true)
                    ->where('data.id', $filial_id)
                    ->etc()
            );
    }

    public function test_fail_update_filial_with_empty_parameters(): void
    {
        /**
         * @var User $user
         * @var Company $company
         */
        $user = User::query()->first();
        $company = Company::query()
            ->inRandomOrder()
            ->with('filials')
            ->whereHas('filials')
            ->first();

        $filial_id = $company->filials->random(1)->first()->id;

        $payload = [];

        $this->actingAs($user)
            ->putJson(
                uri: route('api.v1.client.company.filial.update', [$company->id, $filial_id]),
                data: $payload
            )->assertUnprocessable()
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'name.en',
                    'name.ru',
                    'name.hy',
                    'phone',
                    'address',
                    'schedule',
                    'coordinates.latitude',
                    'coordinates.longitude',
                    'is_main',
                    'community_id',
                    'region_id',
                ]
            ]);
    }

    public function test_fail_update_filial_with_wrong_filial_id(): void
    {
        /**
         * @var User $user
         * @var Company $company
         */
        $user = User::query()->first();
        $company = Company::query()
            ->inRandomOrder()
            ->whereHas('filials')
            ->first();

        $filial_id = Filial::query()
            ->where('company_id', '<>', $company->id)
            ->inRandomOrder()
            ->value('id');

        $payload = Filial::factory()->raw();

        $this->actingAs($user)
            ->putJson(
                uri: route('api.v1.client.company.filial.update', [$company->id, $filial_id]),
                data: $payload
            )->assertNotFound()
            ->assertJsonStructure([
                'success',
                'message',
            ])->assertJson(
                fn(AssertableJson $json) => $json
                    ->where('success', false)
                    ->where('message', 'Company not found')
                    ->etc()
            );
    }

    public function test_successfully_delete_filial()
    {
        /**
         * @var User $user
         * @var Company $company
         */
        $user = User::query()->first();
        $company = Company::query()
            ->inRandomOrder()
            ->with('filials')
            ->whereHas('filials')
            ->first();
        $filial_id = $company->filials->random(1)->first()->id;

        $this->actingAs($user)
            ->deleteJson(
                uri: route('api.v1.client.company.filial.destroy', [$company, $filial_id])

            )->assertOk()
            ->assertJsonStructure([
                'message',
                'success'
            ])->assertJson(
                fn(AssertableJson $json) => $json
                    ->where('success', true)
                    ->where('message', 'Filial deleted')
                    ->etc()
            );

        $this->assertSoftDeleted('filials', [
            'id' => $filial_id
        ]);
    }

    public function test_fail_delete_filial_with_wrong_filial_id()
    {
        /**
         * @var User $user
         * @var Company $company
         */
        $user = User::query()->first();
        $company = Company::query()
            ->inRandomOrder()
            ->whereHas('filials')
            ->first();

        $filial_id = Filial::query()
            ->where('company_id', '<>', $company->id)
            ->inRandomOrder()
            ->value('id');

        $this->actingAs($user)
            ->deleteJson(
                uri: route('api.v1.client.company.filial.destroy', [$company, $filial_id])

            )->assertNotFound()
            ->assertJsonStructure([
                'message',
                'success'
            ])->assertJson(
                fn(AssertableJson $json) => $json
                    ->where('success', false)
                    ->where('message', 'Company not found')
                    ->etc()
            );

        $this->assertDatabaseHas('filials', [
            'id' => $filial_id
        ]);
    }
}
