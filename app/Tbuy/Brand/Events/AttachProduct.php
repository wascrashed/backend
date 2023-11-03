<?php

namespace App\Tbuy\Brand\Events;

use App\Tbuy\Brand\DTOs\BrandAttachProductDTO;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AttachProduct implements ShouldQueue
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public readonly int                   $brand_id,
        public readonly BrandAttachProductDTO $payload
    )
    {
    }
}
