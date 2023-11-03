<?php

namespace App\Tbuy\Attributable\Services;

use App\Tbuy\Attributable\Interfaces\Attributable;
use Illuminate\Support\Collection;

interface AttributableService
{
    public function prepareAndCreate(Attributable $attributable, Collection $collection): Attributable;

    public function preparePayload(Collection $collection): Collection;

    public function removeExistingAttributeValues(Attributable $attributable, Collection $payload): Collection;

    public function prepareAndSetIsNameTrue(Attributable $attributable, Collection $payload): Attributable;
}
