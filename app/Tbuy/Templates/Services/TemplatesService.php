<?php

namespace App\Tbuy\Templates\Services;

use App\Tbuy\Templates\DTOs\TemplatesDTO;
use App\Tbuy\Templates\Models\Templates;
use Illuminate\Database\Eloquent\Collection;

interface TemplatesService
{
    public function getWithCache(): Collection;

    public function createAndClearCache(TemplatesDTO $payload): Templates;

    public function updateAndClearCache(Templates $banner, TemplatesDTO $payload): Templates;

    public function deleteAndClearCache(Templates $banner): void;
}
