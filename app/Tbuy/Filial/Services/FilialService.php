<?php

namespace App\Tbuy\Filial\Services;

use App\Tbuy\Company\Models\Company;
use App\Tbuy\Filial\DTOs\FilialDTO;
use App\Tbuy\Filial\Models\Filial;
use Illuminate\Database\Eloquent\Collection;

interface FilialService
{
    public function getListWithCache(): Collection;

    public function setCompany(Company $company): static;

    public function createAndClearCache(FilialDTO $payload): Filial;

    public function updateAndClearCache(Filial $filial, FilialDTO $payload): Filial;

    public function deleteAndClearCache(Filial $filial): bool;
}
