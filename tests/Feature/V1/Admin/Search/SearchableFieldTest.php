<?php

namespace Tests\Feature\V1\Admin\Search;


use App\Tbuy\ModelInfo\Models\ModelField;
use App\Tbuy\Search\Model\SearchableModel;
use App\Tbuy\Search\Model\SearchableField;
use App\Tbuy\User\Models\User;
use App\Tbuy\User\Repositories\UserRepository;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class SearchableFieldTest extends TestCase
{
    public function test_successfully_index(): void
    {
        /** @var User $user */
        $user = User::query()->first();

        $this->actingAs($user)
            ->withHeader('Accept', 'application/json')
            ->getJson(route('api.v1.admin.search_field.index'))
            ->assertOk()
            ->assertJsonStructure([
                "success",
                "message",
                "data" => [
                    [
                        "id",
                        "model_field" => [
                            "id",
                            "name",
                            "slug"
                        ],
                        "searchable_model" => [
                            "id",
                            "priority",
                            "count"
                        ],
                        "priority"
                    ]
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

        $modelField = ModelField::query()->inRandomOrder()->first();
        $searchableModel = SearchableModel::query()->inRandomOrder()->first();

        $data = [
            'model_field_id' => $modelField->id,
            'searchable_model_id' => $searchableModel->id,
            'priority' => 1,
        ];

        $this->actingAs($user)
            ->withHeader('Accept', 'application/json')
            ->postJson(route('api.v1.admin.search_field.store'), $data)
            ->assertCreated()
            ->assertJsonStructure([
                "success",
                "message",
                "data" => [
                    "id",
                    "model_field" => [
                        "id",
                        "name",
                        "slug"
                    ],
                    "searchable_model" => [
                        "id",
                        "priority",
                        "count"
                    ],
                    "priority"
                ]
            ])
            ->assertJson(
                fn(AssertableJson $json) => $json->where('success', true)->etc()
            );

        $this->assertDatabaseHas('searchable_fields', $data);
    }

    public function test_fail_store_with_empty_data(): void
    {
        /** @var User $user */
        $user = User::query()->first();

        $data = [];

        $this->actingAs($user)
            ->withHeader('Accept', 'application/json')
            ->postJson(route('api.v1.admin.search_field.store'), $data)
            ->assertUnprocessable()
            ->assertJsonStructure([
                "message",
                "errors" => [
                    'model_field_id',
                    'searchable_model_id',
                    'priority',
                ]
            ]);
    }

    public function test_successfully_show(): void
    {
        /** @var User $user */
        /** @var SearchableField $searchableField */
        $user = User::query()->first();

        $searchableField = SearchableField::query()->inRandomOrder()->first();

        $this->actingAs($user)
            ->withHeader('Accept', 'application/json')
            ->getJson(route('api.v1.admin.search_field.show', $searchableField->id))
            ->assertOk()
            ->assertJsonStructure([
                "success",
                "message",
                "data" => [
                    "id",
                    "model_field" => [
                        "id",
                        "name",
                        "slug"
                    ],
                    "searchable_model" => [
                        "id",
                        "priority",
                        "count"
                    ],
                    "priority"
                ]
            ])
            ->assertJson(
                fn(AssertableJson $json) => $json
                    ->where('success', true)
                    ->where('data.id', $searchableField->id)
                    ->etc()
            );
    }

    public function test_successfully_update(): void
    {
        /**
         * @var User $user
         * @var SearchableField $searchableField
         * @var ModelField $modelField
         * @var SearchableModel $searchableModel
         */

        $user = User::query()->first();
        $searchableField = SearchableField::query()->inRandomOrder()->first();

        $modelField = ModelField::query()->inRandomOrder()->first();
        $searchableModel = SearchableModel::query()->inRandomOrder()->first();

        $data = [
            'model_field_id' => $modelField->id,
            'searchable_model_id' => $searchableModel->id,
            'priority' => 1,
        ];
        $this->actingAs($user)
            ->withHeader('Accept', 'application/json')
            ->putJson(route('api.v1.admin.search_field.update', $searchableField->id), $data)
            ->assertOk()
            ->assertJsonStructure([
                "success",
                "message",
                "data" => [
                    "id",
                    "model_field" => [
                        "id",
                        "name",
                        "slug"
                    ],
                    "searchable_model" => [
                        "id",
                        "priority",
                        "count"
                    ],
                    "priority"
                ]
            ])
            ->assertJson(
                fn(AssertableJson $json) => $json
                    ->where('success', true)
                    ->where('data.id', $searchableField->id)
                    ->where('data.model_field.id', $modelField->id)
                    ->where('data.searchable_model.id', $searchableModel->id)
                    ->etc()
            );

        $this->assertDatabaseHas('searchable_fields', ['id' => $searchableField->id] + $data);
    }

    public function test_error_update_with_empty_data(): void
    {
        /**
         * @var User $user
         * @var SearchableField $searchableField
         */

        $user = User::query()->first();
        $searchableField = SearchableField::query()->inRandomOrder()->first();

        $data = [];
        $this->actingAs($user)
            ->withHeader('Accept', 'application/json')
            ->putJson(route('api.v1.admin.search_field.update', $searchableField->id), $data)
            ->assertUnprocessable()
            ->assertJsonStructure([
                "message",
                "errors" => [
                    'model_field_id',
                    'searchable_model_id',
                    'priority',
                ]
            ]);
    }

    public function test_successfully_destroy(): void
    {
        /**
         * @var User $user
         * @var SearchableField $searchableField
         */
        $user = User::query()->first();
        $searchableField = SearchableField::query()->inRandomOrder()->first();

        $this->actingAs($user)
            ->withHeader('Accept', 'application/json')
            ->deleteJson(route('api.v1.admin.search_field.destroy', $searchableField->id))
            ->assertSuccessful()
            ->assertJsonStructure([
                "success",
                "message"
            ])
            ->assertJson(
                fn(AssertableJson $json) => $json->where('success', true)->etc()
            );

        $this->assertSoftDeleted('searchable_fields', [
            'id' => $searchableField->id
        ]);
    }
}
