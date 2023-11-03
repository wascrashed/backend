<?php

namespace Tests\Feature\V1\Admin\Invite;

use App\Tbuy\Company\Models\Company;
use App\Tbuy\Invite\DTOs\InviteDTO;
use App\Tbuy\Invite\Events\InviteActivatedEvent;
use App\Tbuy\Invite\Listeners\EmployeeCreate;
use App\Tbuy\Invite\Listeners\UserCreate;
use App\Tbuy\Invite\Models\Invite;
use App\Tbuy\Invite\Notifications\InviteTokenCreated;
use App\Tbuy\Invite\Repositories\InviteRepository;
use App\Tbuy\User\Models\User;
use App\Tbuy\User\Repositories\UserRepository;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Tests\TestCase;

class InviteTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_success_create_invite_and_send_token_to_email(): void
    {
        Notification::fake();

        /** @var User $user */
        $user = User::query()->first();

        $data = [
            'company_id' => $company_id = Company::query()->inRandomOrder()->first()->id,
            'email' => 'admin@mail.com',
            'username' => 'some-username',
            'expired_at' => '2024-01-04'
        ];

        $this->actingAs($user)->postJson(route('api.v1.admin.invite.store'), $data)
            ->assertCreated()
            ->assertJsonStructure([
                "success",
                "message"
            ])
            ->assertJson([
                'success' => true,
                'message' => 'Token created'
            ]);

        $invite = Invite::query()
            ->where('company_id', $company_id)
            ->latest()
            ->first();

        Notification::assertSentTo($invite, InviteTokenCreated::class);
    }

    public function test_fail_validation()
    {
        /** @var UserRepository $userRepository */
        $userRepository = $this->app->make(UserRepository::class);

        $user = $userRepository->findById(1);

        $data = [
            'email' => 'admin@mail.com',
            'username' => 'some-username',
            'expired_at' => '2024-01-04'
        ];

        $this->actingAs($user)->postJson(route('api.v1.admin.invite.store'), $data)
            ->assertUnprocessable()
            ->assertJsonStructure([
                "message",
                "errors" => [
                    "company_id"
                ]
            ]);
    }

    public function test_success_activate_token()
    {
        Event::fake();

        /** @var InviteRepository $inviteRepository */
        $inviteRepository = $this->app->make(InviteRepository::class);

        $invite = $inviteRepository->create(new InviteDTO(
            company_id: Company::query()->inRandomOrder()->first()->id,
            email: 'admin@mail.com',
            username: 'some-username',
            token: Str::random(128),
            expired_at: '2024-01-04'
        ));

        /** @var User $user */
        $user = User::query()->first();

        $this->actingAs($user)
            ->patchJson(route('api.v1.admin.invite.activate', ['token' => $invite->token]))
            ->assertSuccessful()
            ->assertJsonStructure([
                "success",
                "message"
            ])
            ->assertJson([
                'success' => true,
                'message' => 'Token activated'
            ]);

        Event::assertDispatched(InviteActivatedEvent::class,
            fn(InviteActivatedEvent $event) => $event->invite->id === $invite->id && $event->password
        );
        Event::assertListening(InviteActivatedEvent::class, UserCreate::class);
        Event::assertListening(InviteActivatedEvent::class, EmployeeCreate::class);

        /** @var Invite $invite */
        $invite = Invite::query()->find($invite->id);

        $this->assertNotNull($invite->activated_at);
    }

    public function test_activate_fail_validation()
    {
        /** @var User $user */
        $user = User::query()->first();

        $this->actingAs($user)
            ->patchJson(route('api.v1.admin.invite.activate'))
            ->assertUnprocessable()
            ->assertJsonStructure([
                "message",
                "errors" => [
                    "token"
                ]
            ]);
    }
}
