<?php

namespace App\Tbuy\Filial\Repositories;

use App\Tbuy\Company\Models\Company;
use App\Tbuy\Filial\DTOs\FilialDTO;
use App\Tbuy\Filial\Models\Filial;
use Illuminate\Database\Eloquent\Collection;

interface FilialRepository
{
    public function setCompany(Company $company): static;

    public function get(): Collection;

    public function create(FilialDTO $payload): Filial;

    public function update(Filial $filial, FilialDTO $payload): Filial;

    public function delete(Filial $filial): bool;
}
