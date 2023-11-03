<?php

namespace Tests\Feature\V1\Admin\Menu;

use App\Tbuy\Menu\Models\Menu;
use App\Tbuy\User\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class MenuControllerTest extends TestCase
{
    public function test_successfully_get_list(): void
    {
        /** @var User $user */
        $user = User::query()->first();

        $this->actingAs($user)
            ->getJson(
                uri: route('api.v1.admin.menu.index')
            )->assertOk()
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    [
                        'id',
                        'name',
                        'slug',
                        'image',
                        'children'
                    ]
                ]
            ])
            ->assertJson(
                fn (AssertableJson $json) => $json
                    ->where('success', true)
                    ->etc()
            );
    }

    public function test_successfully_create_new_menu()
    {
        /** @var User $user */
        $user = User::query()->first();

        $menuPayload = Menu::factory()->raw([
            'image' => UploadedFile::fake()->image('menu.jpg')
        ]);

        $this->actingAs($user)
            ->postJson(
                uri: route('api.v1.admin.menu.store'),
                data: $menuPayload
            )
            ->assertCreated()
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'name',
                    'slug',
                    'image'
                ]
            ])
            ->assertJson(
                fn (AssertableJson $json) => $json
                    ->where('data.name', $menuPayload['name'])->etc()
            );
    }

    public function test_successfully_set_user()
    {
        /**
         * @var User $user
         * @var Menu $menu
         */
        $user = User::query()->first();

        $menu = Menu::query()->inRandomOrder()->first();
        $userMenu = User::query()->inRandomOrder()->first();

        $this->actingAs($user)
            ->postJson(
                uri: route('api.v1.admin.menu.user.store', $menu->id),
                data: [
                    'user_id' => $userMenu->id,
                    'menu' => [$menu->id]
                ]
            )
            ->assertCreated()
            ->assertJsonStructure([
                'success',
                'message'
            ])
            ->assertJson(
                fn (AssertableJson $json) => $json
                    ->where('success', true)
                    ->where('message', 'Menu set')
                    ->etc()
            );
    }

    public function test_successfully_update()
    {
        /**
         * @var User $user
         * @var Menu $menu
         */
        $user = User::query()->first();

        $menu = Menu::query()->inRandomOrder()->first();

        $menuPayload = Menu::factory()->raw();

        $this->actingAs($user)
            ->putJson(
                uri: route('api.v1.admin.menu.update', $menu->id),
                data: $menuPayload
            )
            ->assertOk()
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'name',
                    'slug',
                    'image'
                ]
            ]);
    }

    public function test_fail_update_validation_without_body_parameters()
    {
        /**
         * @var User $user
         * @var Menu $menu
         */
        $user = User::query()->first();

        $menu = Menu::query()->inRandomOrder()->first();

        $menuPayload = [];

        $this->actingAs($user)
            ->putJson(
                uri: route('api.v1.admin.menu.update', $menu->id),
                data: $menuPayload
            )
            ->assertUnprocessable()
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'name',
                    'slug',
                ]
            ]);
    }

    public function test_successfully_delete()
    {
        /**
         * @var User $user
         * @var Menu $menu
         */
        $user = User::query()->first();
        $menu = Menu::query()->inRandomOrder()->first();

        $this->actingAs($user)
            ->deleteJson(
                uri: route('api.v1.admin.menu.delete', $menu->id)

            )->assertOk()
            ->assertJsonStructure([
                'message',
                'success'
            ])->assertJson(
                fn (AssertableJson $json) => $json
                    ->where('success', true)
                    ->where('message', 'Menu deleted')
                    ->etc()
            );

        $this->assertSoftDeleted('menus', [
            'id' => $menu->id
        ]);
    }
}
