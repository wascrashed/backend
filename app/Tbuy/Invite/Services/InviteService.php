<?php

namespace App\Tbuy\Invite\Services;

use App\Tbuy\Invite\DTOs\InviteDTO;
use App\Tbuy\Invite\Exceptions\InviteExpiredException;
use App\Tbuy\Invite\Models\Invite;

interface InviteService
{
    public function createAndSendNotification(InviteDTO $payload): Invite;

    /**
     * @param string $token
     * @return Invite
     * @throws InviteExpiredException
     */
    public function activateByToken(string $token): Invite;
}
