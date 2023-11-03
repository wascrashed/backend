<?php

namespace App\Tbuy\Invite\Repositories;

use App\Tbuy\Invite\DTOs\InviteDTO;
use App\Tbuy\Invite\Models\Invite;

class InviteRepositoryImplementation implements InviteRepository
{
    public function findInviteByToken(string $token): ?Invite
    {
        /** @var Invite $invite */
        $invite = Invite::query()
            ->where('token', '=', $token)
            ->first();

        return $invite;
    }

    public function create(InviteDTO $payload): Invite
    {
        $invite = new Invite($payload->toArray());
        $invite->save();

        return $invite;
    }

    public function activate(Invite $invite): Invite
    {
        $invite->fill([
            'activated_at' => now()
        ]);
        $invite->save();

        return $invite;
    }
}
