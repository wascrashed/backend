<?php

namespace Tests\Feature\V1\Admin\Auth;

use App\Tbuy\User\Models\User;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    public function test_login_succes()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('view any' );
        $userData = [
            'email' => $user->email,
            'password' => 'password',
        ];

        $response = $this->postJson(route('api.v1.admin.auth.login'), $userData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'user' => [
                        'id',
                        'name',
                        'email',
                        'created_at',
                    ],
                    'access_token',
                ],
                'message',
            ])
            ->assertJson([
                'message' => 'Login success',
            ]);
    }

    public function test_login_failed()
    {
        $userData = [
            'email' => 'nonexistent@example.com',
            'password' => 'invalidpassword',
        ];

        $response = $this->postJson(route('api.v1.admin.auth.login'), $userData);

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Login failed',
            ]);
    }


    public function test_logout()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('view any' );
        $user->givePermissionTo('view any' );
        $response = $this->actingAs($user)
            ->postJson(route('api.v1.admin.auth.logout'));

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Logout success',
            ]);
    }
    public function test_get_auth_user()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('view any' );
        $response = $this->actingAs($user)
            ->getJson(route('api.v1.admin.auth.user'));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                ],
                'message',
            ])
            ->assertJson([
                'message' => 'Информация об авторизованном пользователе',
            ]);
    }
}
