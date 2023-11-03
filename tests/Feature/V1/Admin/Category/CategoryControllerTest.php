<?php

namespace Tests\Feature\V1\Admin\Category;

use App\Tbuy\Category\Models\Category;
use App\Tbuy\User\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    public function test_index()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('view category');
        $this->actingAs($user);

        $response = $this->getJson(route('api.v1.admin.category.index'));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'slug',
                    ]
                ]
            ]);
    }

    public function test_get_child_level()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('ratio category');
        $this->actingAs($user);

        $grandParentCategory = Category::factory()->create();
        $parentCategory = Category::factory()->create(['parent_id' => $grandParentCategory->id]);
        $childCategory = Category::factory()->create(['parent_id' => $parentCategory->id]);

        $response = $this->getJson(route('api.v1.admin.category.ratio', ['category' => $childCategory->id]));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'data' => [
                    'ratio' => 3
                ]
            ]);
    }

    public function test_store()
    {
        /**
         * @var User $user
         */

        $user = User::factory()->create();
        $user->givePermissionTo('store category');
        $categoryData = Category::factory()->raw();

        $this->actingAs($user)
            ->postJson(route('api.v1.admin.category.store'), $categoryData)
            ->assertCreated()
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'name',
                    'slug',
                ]
            ])->assertJson(
                fn(AssertableJson $json) => $json
                    ->where('success', true)
                    ->etc()
            );
    }

    public function test_update()
    {
        /**
         * @var User $user
         * @var Category $category
         */

        $user = User::factory()->create();
        $user->givePermissionTo('update category');
        $category = Category::factory()->create();

        $categoryData = Category::factory()->raw();

        $this->actingAs($user)
            ->putJson(
                route('api.v1.admin.category.update', $category->id),
                $categoryData
            )
            ->assertOk()
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'name',
                    'slug'
                ]
            ])
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => $category->id,
                    'name' => $categoryData['name']['ru'],
                    'slug' => $categoryData['slug']
                ]
            ]);
    }

    public function test_destroy()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('delete category');

        $this->actingAs($user);

        $category = Category::factory()->create();

        $response = $this->deleteJson(route('api.v1.admin.category.destroy', ['category' => $category->id]));

        $response->assertStatus(Response::HTTP_OK);

        $this->assertSoftDeleted('categories', [
            'id' => $category->id
        ]);
    }
}
