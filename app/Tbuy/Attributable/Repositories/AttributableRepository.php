<?php

namespace App\Tbuy\Attributable\Repositories;

use App\Tbuy\Attributable\Interfaces\Attributable;
use App\Tbuy\Attributable\Models\Attributable as AttributableModel;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

interface AttributableRepository
{
    public function get(string $type, int $id): EloquentCollection;

    public function latest(string $type, int $id): ?AttributableModel;

    public function setAttribute(Attributable $attributable, Collection $payload): Attributable;

    public function setIsNameTrue(Attributable $attributable, Collection $payload): Attributable;
}
