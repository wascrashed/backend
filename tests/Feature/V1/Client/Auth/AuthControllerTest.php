<?php

namespace Tests\Feature\V1\Client\Auth;

use App\Tbuy\User\Mail\ForgotPasswordMail;
use App\Tbuy\User\Models\User;
use App\Tbuy\User\Notifications\ChangePasswordNotification;
use App\Tbuy\User\Notifications\ForgotPasswordNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    public function test_logout()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson(route('api.v1.client.auth.logout'));

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Logout success',
            ]);
    }

    public function test_change_password()
    {
        Notification::fake();
        $user = User::factory()->create(['password' => bcrypt('MySecretPassword')]);

        $requestData = [
            'old_password' => 'MySecretPassword',
            'password' => 'NewPassword456',
            'password_confirmation' => 'NewPassword456',
        ];

        $response = $this->actingAs($user)
            ->postJson(route('api.v1.client.auth.changePassword'), $requestData);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Password changed successfully',
            ]);

        Notification::assertSentTo($user, ChangePasswordNotification::class);

        $this->assertTrue(Hash::check('NewPassword456', $user->password));
    }

    public function test_change_password_validation_error()
    {
        $user = User::factory()->create(['password' => bcrypt('MySecretPassword')]);

        $requestData = [
            'old_password' => 'MySecretPassword',
            'password' => 'one',
            'password_confirmation' => 'one',
        ];

        $response = $this->actingAs($user)
            ->postJson(route('api.v1.client.auth.changePassword'), $requestData);

        $response->assertStatus(422)
            ->assertJson([
                'message' => 'The password field must be at least 8 characters.',
            ]);
    }

    public function test_forgot_password()
    {
        Notification::fake();

        $user = User::factory()->create();

        $requestData = [
            'email' => $user->email,
        ];

        $this->postJson(route('api.v1.client.auth.forgotPassword'), $requestData)
            ->assertStatus(200)
            ->assertJson([
                'message' => 'А password recovery email has been sent',
            ]);

        Notification::assertSentTo($user, ForgotPasswordNotification::class);

        $notification = Notification::sent($user, ForgotPasswordNotification::class)->last();
        $password = $notification->password;

        $this->assertNotEmpty($password);
        $this->assertEquals(8, strlen($password));
    }

    public function test_login_success()
    {
        $user = User::factory()->create();

        $user->givePermissionTo('view any');

        $userData = [
            'email' => $user->email,
            'password' => 'password',
        ];

        $response = $this->postJson(
            uri: route('api.v1.client.auth.login'),
            data: $userData)
            ->assertStatus(200)
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

        $accessToken = $response->json('data.access_token');

        $this->assertNotEmpty($accessToken);
    }

    public function test_login_failed()
    {
        $userData = [
            'email' => 'abc@example.com',
            'password' => 'errorpassword',
        ];

        $response = $this->postJson(route('api.v1.client.auth.login'), $userData);

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Login failed',
            ]);
    }
}
