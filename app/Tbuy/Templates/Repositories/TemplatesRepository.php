<?php

namespace App\Tbuy\Templates\Repositories;

use App\Tbuy\Templates\DTOs\TemplatesDTO;
use App\Tbuy\Templates\Models\Templates;
use Illuminate\Database\Eloquent\Collection;

interface TemplatesRepository
{
    public function get(): Collection;

    public function create(TemplatesDTO $payload): Templates;

    public function update(Templates $banner, TemplatesDTO $payload): Templates;

    public function delete(Templates $banner): void;
}
