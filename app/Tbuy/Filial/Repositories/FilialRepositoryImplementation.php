<?php

namespace App\Tbuy\Filial\Repositories;

use App\Tbuy\Company\Models\Company;
use App\Tbuy\Filial\DTOs\FilialDTO;
use App\Tbuy\Filial\Models\Filial;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class FilialRepositoryImplementation implements FilialRepository
{
    private ?Company $company;

    public function setCompany(Company $company): static
    {
        $this->company = $company;

        return $this;
    }

    public function get(): Collection
    {
        return Filial::query()
            ->when($this->company,
                fn(Builder $builder, Company $company) => $builder->where('company_id', $this->company->id)
            )
            ->get();
    }

    public function create(FilialDTO $payload): Filial
    {
        $filial = new Filial($payload->toArray());
        $filial->save();

        return $filial;
    }

    public function update(Filial $filial, FilialDTO $payload): Filial
    {
        $filial->fill($payload->toArray());
        $filial->save();

        return $filial;
    }

    public function delete(Filial $filial): bool
    {
        return $filial->delete();
    }
}
