<?php

namespace App\Tbuy\Company\Listeners;

use App\Tbuy\Company\Events\CompanyRejected;
use App\Tbuy\Company\Repositories\CompanyRepository;
use App\Tbuy\Rejection\Repository\RejectionRepository;
use Illuminate\Contracts\Queue\ShouldQueue;

class CompanyRejectedListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct(
        private readonly CompanyRepository   $companyRepository,
        private readonly RejectionRepository $rejectionRepository
    )
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CompanyRejected $event): void
    {
        $this->rejectionRepository->create(
            $event->company,
            $event->payload,
            $event->user_id
        );
    }

}
