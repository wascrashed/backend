<?php

namespace App\Tbuy\MenuUserPermission\Events;

use App\Tbuy\MenuUserPermission\DTOs\MenuUserDTO;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MenuUserSet implements ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public readonly MenuUserDTO $payload)
    {
    }
}
