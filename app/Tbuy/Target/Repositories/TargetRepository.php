<?php

namespace App\Tbuy\Target\Repositories;

use App\Tbuy\Target\DTOs\TargetDTO;
use App\Tbuy\Target\DTOs\TargetStatusDTO;
use App\Tbuy\Target\Models\Target;
use Illuminate\Database\Eloquent\Collection;

interface TargetRepository
{
    public function get(): Collection;

    public function create(TargetDTO $dto): Target;

    public function show(Target $target): Target;

    public function update(TargetDTO $dto, Target $target): Target;

    public function delete(Target $target): void;

    public function changeStatus(TargetStatusDTO $dto, Target $target): Target;

    public function incrementViews(Target $target): void;
}
