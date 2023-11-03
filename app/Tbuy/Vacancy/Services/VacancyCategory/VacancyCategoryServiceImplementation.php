<?php

namespace App\Tbuy\Vacancy\Services\VacancyCategory;

use App\Tbuy\Vacancy\DTOs\VacancyCategoryDTO;
use App\Tbuy\Vacancy\Enums\VacancyCategoryCacheKey;
use App\Tbuy\Vacancy\Models\VacancyCategory;
use App\Tbuy\Vacancy\Repositories\VacancyCategory\VacancyCategoryRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class VacancyCategoryServiceImplementation implements VacancyCategoryService
{
    public function __construct(
        private readonly VacancyCategoryRepository $vacancyCategoryRepository
    )
    {
    }

    public function get(): Collection
    {
        return Cache::tags(VacancyCategoryCacheKey::LIST->value)
            ->remember(
                VacancyCategoryCacheKey::LIST->value,
                VacancyCategoryCacheKey::ttl(),
                function () {
                    return $this->vacancyCategoryRepository->get();
                }
            );
    }

    public function create(VacancyCategoryDTO $payload): VacancyCategory
    {
        $category = $this->vacancyCategoryRepository->create($payload);

        Cache::tags(VacancyCategoryCacheKey::LIST)->clear();

        return $category;
    }

    public function update(VacancyCategoryDTO $payload, VacancyCategory $category): VacancyCategory
    {
        $category = $this->vacancyCategoryRepository->update($payload, $category);

        Cache::tags(VacancyCategoryCacheKey::LIST)->clear();

        return $category;
    }

    public function delete(VacancyCategory $category): void
    {
        $category->delete();
    }
}
