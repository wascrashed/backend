<?php

namespace App\Tbuy\Invite\DTOs;

use App\DTOs\BaseDTO;
use Illuminate\Support\Carbon;

class InviteDTO extends BaseDTO
{
    public readonly ?Carbon $expired_at;

    public function __construct(
        public readonly int    $company_id,
        public readonly string $email,
        public readonly string $username,
        public ?string         $token = null,
        ?string                $expired_at = null
    )
    {
        $this->expired_at = $expired_at
            ? Carbon::createFromFormat('Y-m-d', $expired_at)->endOfDay()
            : null;
    }
}
