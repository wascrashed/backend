<?php

namespace Tests\Feature\V1\Admin\MenuUserPermission;


use App\Tbuy\Menu\Models\Menu;
use App\Tbuy\MenuUserPermission\Models\MenuUserPermission;
use App\Tbuy\User\Models\User;
use App\Tbuy\User\Repositories\UserRepository;
use PHPUnit\Framework\MockObject\Exception;
use Tests\TestCase;

class MenuUserPermissionControllerTest extends TestCase
{
    public function test_set_user_to_menu()
    {
        /** @var User $user */
        $user = User::query()->first();
        $menuIds = Menu::factory(10)->create()->pluck('id')->toArray();

        $payload = [
            "user_id" => $user->id,
            'menu' => $menuIds
        ];

        $this->actingAs($user)
            ->post('api/v1/admin/menu/set-user', $payload)
            ->assertJsonStructure([
                "success",
                "message",
            ])->assertJson([
                "success" => true,
                "message" => "Menu set"
            ])->assertCreated();

        foreach ($menuIds as $menuId) {
            $this->assertDatabaseHas('menu_user_permission', [
                'user_id' => $user->id,
                'menu_id' => $menuId
            ]);
        }
    }
}
