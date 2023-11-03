<?php

namespace App\Tbuy\Invite\Listeners;

use App\Tbuy\Invite\Events\InviteActivatedEvent;
use App\Tbuy\User\DTOs\UserDTO;
use App\Tbuy\User\Enums\CacheKey;
use App\Tbuy\User\Repositories\UserRepository;
use Illuminate\Support\Facades\Cache;

class UserCreate
{
    /**
     * Create the event listener.
     */
    public function __construct(
        private readonly UserRepository $userRepository,
    )
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(InviteActivatedEvent $event): void
    {
        $user = $this->userRepository->findByEmail($event->invite->email);

        if (!$user) {
            $this->userRepository->store(
                new UserDTO(
                    name: $event->invite->username,
                    email: $event->invite->email,
                    password: $event->password
                )
            );

            Cache::forget(CacheKey::USER_LIST->value);
        }

    }
}
