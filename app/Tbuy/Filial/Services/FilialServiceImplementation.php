<?php

namespace App\Tbuy\Filial\Services;

use App\Tbuy\Company\Models\Company;
use App\Tbuy\Filial\DTOs\FilialDTO;
use App\Tbuy\Filial\Enums\CacheKey;
use App\Tbuy\Filial\Models\Filial;
use App\Tbuy\Filial\Repositories\FilialRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;
use Throwable;

class FilialServiceImplementation implements FilialService
{
    private ?Company $company;

    public function __construct(
        private readonly FilialRepository $filialRepository
    )
    {
    }

    public function setCompany(Company $company): static
    {
        $this->company = $company;

        return $this;
    }

    public function getListWithCache(): Collection
    {
        $company = $this->company?->id;

        return Cache::tags(CacheKey::FILIAL_TAG->value)->remember(
            CacheKey::LIST->setKeys(compact('company')),
            CacheKey::ttl(),
            fn() => $this->filialRepositoryWithCompany()->get()
        );
    }

    /**
     * @param FilialDTO $payload
     * @return Filial
     * @throws Throwable
     */
    public function createAndClearCache(FilialDTO $payload): Filial
    {
        throw_if(
            is_null($this->company),
            ModelNotFoundException::class,
            'Company not found'
        );

        $filial = $this->filialRepositoryWithCompany()->create($payload);

        Cache::tags(CacheKey::FILIAL_TAG->value)->clear();

        return $filial->load(['community', 'region']);
    }

    /**
     * @throws Throwable
     */
    public function updateAndClearCache(Filial $filial, FilialDTO $payload): Filial
    {
        throw_if(
            is_null($this->company) || $this->company->id !== $filial->company_id,
            ModelNotFoundException::class,
            'Company not found'
        );

        $filial = $this->filialRepositoryWithCompany()->update($filial, $payload);

        Cache::tags(CacheKey::FILIAL_TAG->value)->clear();

        return $filial->load(['community', 'region']);
    }

    /**
     * @param Filial $filial
     * @return bool
     * @throws Throwable
     */
    public function deleteAndClearCache(Filial $filial): bool
    {
        throw_if(
            is_null($this->company) || $this->company->id !== $filial->company_id,
            ModelNotFoundException::class,
            'Company not found'
        );

        $is_deleted = $this->filialRepositoryWithCompany()->delete($filial);

        if ($is_deleted) {
            Cache::tags(CacheKey::FILIAL_TAG->value)->clear();
        }

        return $is_deleted;
    }

    private function filialRepositoryWithCompany(): FilialRepository
    {
        return $this->filialRepository->setCompany($this->company);
    }
}
