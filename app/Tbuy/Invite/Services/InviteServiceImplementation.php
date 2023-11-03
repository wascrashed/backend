<?php

namespace App\Tbuy\Invite\Services;

use App\Tbuy\Invite\DTOs\InviteDTO;
use App\Tbuy\Invite\Events\InviteActivatedEvent;
use App\Tbuy\Invite\Exceptions\InviteExpiredException;
use App\Tbuy\Invite\Models\Invite;
use App\Tbuy\Invite\Notifications\InviteTokenActivated;
use App\Tbuy\Invite\Notifications\InviteTokenCreated;
use App\Tbuy\Invite\Repositories\InviteRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InviteServiceImplementation implements InviteService
{
    public function __construct(
        private readonly InviteRepository $inviteRepository
    )
    {
    }

    public function createAndSendNotification(InviteDTO $payload): Invite
    {
        $payload->token = Str::random(128);

        $invite = $this->inviteRepository->create($payload);

        $invite->notify(new InviteTokenCreated());

        return $invite;
    }

    /**
     * @throws ModelNotFoundException|InviteExpiredException
     */
    public function activateByToken(string $token): Invite
    {
        $invite = $this->inviteRepository->findInviteByToken($token);

        if (!$invite) {
            throw new ModelNotFoundException("Приглашение не найдено");
        }

        if ($invite->is_expired) {
            throw new InviteExpiredException("Приглашение просрочено");
        }

        $password = Str::password(8);

        $invite = DB::transaction(function () use ($invite, $password) {

            InviteActivatedEvent::dispatch($invite, $password);

            return $this->inviteRepository->activate($invite);
        });

        $invite->notify(new InviteTokenActivated($password));

        return $invite;
    }
}
