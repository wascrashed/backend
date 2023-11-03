<?php

namespace App\Tbuy\Invite\Repositories;

use App\Tbuy\Invite\DTOs\InviteDTO;
use App\Tbuy\Invite\Models\Invite;

interface InviteRepository
{
    public function findInviteByToken(string $token): ?Invite;

    public function create(InviteDTO $payload): Invite;

    public function activate(Invite $invite): Invite;
}
