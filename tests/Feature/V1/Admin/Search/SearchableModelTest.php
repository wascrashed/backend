<?php

namespace Tests\Feature\V1\Admin\Search;


use App\Tbuy\ModelInfo\Models\ModelList;
use App\Tbuy\Product\Models\Product;
use App\Tbuy\Search\Model\SearchableModel;
use App\Tbuy\User\Models\User;
use App\Tbuy\User\Repositories\UserRepository;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class SearchableModelTest extends TestCase
{
    public function test_successfully_index(): void
    {
        /**
         * @var User $user
         * @var Product $product
         */
        $user = User::query()->first();
        $product = Product::query()->first();

        $this->actingAs($user)
            ->withHeader('Accept', 'application/json')
            ->getJson(route('api.v1.admin.search_model.index', ['query' => $product->name]))
            ->assertOk()
            ->assertJsonStructure([
                "success",
                "message",
                "data"
            ])
            ->assertJson(
                fn(AssertableJson $json) => $json
                    ->where('success', true)
                    ->where('message', 'Searchable model list')
                    ->etc()
            );
    }

    public function test_successfully_store(): void
    {
        /**
         * @var User $user
         * @var ModelList $modelList
         */
        $user = User::query()->first();

        $modelList = ModelList::query()->inRandomOrder()->first();

        $data = [
            'model_id' => $modelList->id,
            'priority' => 1,
            'count' => 10
        ];

        $this->actingAs($user)
            ->withHeader('Accept', 'application/json')
            ->postJson(route('api.v1.admin.search_model.store'), $data)
            ->assertCreated()
            ->assertJsonStructure([
                "success",
                "message",
                "data" => [
                    "id",
                    "model" => [
                        "id",
                        "model",
                        "label",
                    ],
                    "priority",
                    "count"
                ]
            ])
            ->assertJson(
                fn(AssertableJson $json) => $json->where('success', true)->etc()
            );
    }

    public function test_fail_store_with_empty_data(): void
    {
        /**
         * @var User $user
         */
        $user = User::query()->first();


        $data = [];

        $this->actingAs($user)
            ->withHeader('Accept', 'application/json')
            ->postJson(route('api.v1.admin.search_model.store'), $data)
            ->assertUnprocessable()
            ->assertJsonStructure([
                "message",
                "errors" => [
                    "model_id",
                    "priority",
                    "count"
                ]
            ]);
    }

    public function test_successfully_show(): void
    {
        /**
         * @var User $user
         * @var SearchableModel $searchableModel
         */
        $user = User::query()->first();

        $searchableModel = SearchableModel::query()->inRandomOrder()->first();

        $this->actingAs($user)
            ->withHeader('Accept', 'application/json')
            ->getJson(route('api.v1.admin.search_model.show', $searchableModel->id))
            ->assertOk()
            ->assertJsonStructure([
                "success",
                "message",
                "data" => [
                    "id",
                    "model" => [
                        "id",
                        "model",
                        "label",
                    ],
                    "priority",
                    "count"
                ]
            ])
            ->assertJson(
                fn(AssertableJson $json) => $json
                    ->where('success', true)
                    ->where('data.id', $searchableModel->id)
                    ->etc()
            );
    }

    public function test_successfully_update(): void
    {
        /**
         * @var User $user
         * @var SearchableModel $searchableModel
         * @var ModelList $modelList
         */
        $user = User::query()->first();

        $searchableModel = SearchableModel::query()->inRandomOrder()->first();
        $modelList = ModelList::query()->inRandomOrder()->first();

        $data = [
            'model_id' => $modelList->id,
            'priority' => 1,
            'count' => 10
        ];
        $this->actingAs($user)
            ->withHeader('Accept', 'application/json')
            ->putJson(route('api.v1.admin.search_model.update', $searchableModel->id), $data)
            ->assertOk()
            ->assertJsonStructure([
                "success",
                "message",
                "data" => [
                    "id",
                    "model" => [
                        "id",
                        "model",
                        "label",
                    ],
                    "priority",
                    "count"
                ]
            ])
            ->assertJson(
                fn(AssertableJson $json) => $json
                    ->where('success', true)
                    ->where('data.id', $searchableModel->id)
                    ->where('data.priority', $data['priority'])
                    ->where('data.count', $data['count'])
                    ->etc()
            );
        $this->assertDatabaseHas('searchable_models', $data + ['id' => $searchableModel->id]);
    }

    public function test_fail_update_with_empty_data(): void
    {
        /**
         * @var User $user
         * @var SearchableModel $searchableModel
         */
        $user = User::query()->first();

        $searchableModel = SearchableModel::query()->inRandomOrder()->first();

        $data = [];
        $this->actingAs($user)
            ->withHeader('Accept', 'application/json')
            ->putJson(route('api.v1.admin.search_model.update', $searchableModel->id), $data)
            ->assertUnprocessable()
            ->assertJsonStructure([
                "message",
                "errors" => [
                    "model_id",
                    "priority",
                    "count"
                ]
            ]);
    }

    public function test_successfully_destroy(): void
    {
        /**
         * @var User $user
         * @var SearchableModel $searchableModel
         */
        $user = User::query()->first();

        $searchableModel = SearchableModel::query()->inRandomOrder()->first();

        $this->actingAs($user)
            ->withHeader('Accept', 'application/json')
            ->deleteJson(route('api.v1.admin.search_model.destroy', $searchableModel->id))
            ->assertSuccessful()
            ->assertJsonStructure([
                "success",
                "message"
            ])
            ->assertJson(
                fn(AssertableJson $json) => $json->where('success', true)->etc()
            );
        $this->assertSoftDeleted('searchable_models', ['id' => $searchableModel->id]);
    }
}
