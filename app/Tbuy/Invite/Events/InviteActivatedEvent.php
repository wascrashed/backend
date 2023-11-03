<?php

namespace App\Tbuy\Invite\Events;

use App\Tbuy\Invite\Models\Invite;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InviteActivatedEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public readonly Invite $invite,
        public readonly string $password
    )
    {
        //
    }
}
