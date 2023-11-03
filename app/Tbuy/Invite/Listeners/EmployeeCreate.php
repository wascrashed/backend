<?php

namespace App\Tbuy\Invite\Listeners;

use App\Tbuy\Employee\DTOs\EmployeeDTO;
use App\Tbuy\Employee\Enums\CacheKey;
use App\Tbuy\Employee\Repositories\EmployeeRepository;
use App\Tbuy\Invite\Events\InviteActivatedEvent;
use App\Tbuy\User\Repositories\UserRepository;
use Illuminate\Support\Facades\Cache;

class EmployeeCreate
{
    /**
     * Create the event listener.
     */
    public function __construct(
        private readonly EmployeeRepository $employeeRepository,
        private readonly UserRepository     $userRepository,
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

        if ($this->employeeRepository->findByCompanyIdAndUserId($event->invite->company_id, $user->id)) {
            return;
        }

        $this->employeeRepository->create(
            $user,
            new EmployeeDTO(
                company_id: $event->invite->company_id,
                email: $event->invite->email,
                username: $event->invite->username,
                password: $event->password
            )
        );

        Cache::tags(CacheKey::TAG)->clear();
    }
}
