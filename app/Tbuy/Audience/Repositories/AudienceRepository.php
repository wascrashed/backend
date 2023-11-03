<?php

namespace App\Tbuy\Audience\Repositories;

use App\Tbuy\Audience\DTOs\AudienceDTO;
use App\Tbuy\Audience\Models\Audience;
use Illuminate\Database\Eloquent\Collection;

interface AudienceRepository
{
    public function get(): Collection;

    public function create(AudienceDTO $dto): Audience;

    public function show(Audience $audience): Audience;

    public function update(AudienceDTO $dto, Audience $audience): Audience;

    public function delete(Audience $audience): void;
}
