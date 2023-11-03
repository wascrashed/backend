<?php

namespace App\Tbuy\Brand\Listeners;

use App\Tbuy\Brand\Events\BrandRejected;
use App\Tbuy\Brand\Repositories\BrandRepository;
use App\Tbuy\Rejection\Repository\RejectionRepository;
use Illuminate\Contracts\Queue\ShouldQueue;

class BrandRejectedListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct(
        private readonly BrandRepository     $brandRepository,
        private readonly RejectionRepository $rejectionRepository
    )
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BrandRejected $event): void
    {
        $this->rejectionRepository->create(
            $this->brandRepository->findById($event->brand_id),
            $event->payload,
            $event->user_id
        );
    }

}
