<?php

namespace App\Tbuy\Attributable\Observers;

use App\Tbuy\Attributable\Models\Attributable;
use App\Tbuy\Attributable\Repositories\AttributableRepository;

class AttributableObserver
{
    public function __construct(
        private readonly AttributableRepository $attributableRepository
    )
    {
    }

    public function creating(Attributable $attributable): void
    {
        $latest = $this->attributableRepository->latest($attributable->attributable_type, $attributable->attributable_id);

        $attributable->fill([
            'order' => ($latest->order ?? 0) + 1
        ]);
    }
}
