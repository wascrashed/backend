<?php

namespace App\Tbuy\Vacancy\Repositories\VacancyCategory;

use App\Tbuy\Vacancy\DTOs\VacancyCategoryDTO;
use App\Tbuy\Vacancy\Models\VacancyCategory;
use Illuminate\Database\Eloquent\Collection;

class VacancyCategoryRepositoryImplementation implements VacancyCategoryRepository
{
    public function get(): Collection
    {
        return VacancyCategory::all();
    }

    public function create(VacancyCategoryDTO $payload): VacancyCategory
    {
        $category = new VacancyCategory();
        $category = $this->addTranslations($payload, $category);
        $category->save();

        return $category;
    }

    public function update(VacancyCategoryDTO $payload, VacancyCategory $category): VacancyCategory
    {
        $category = $this->addTranslations($payload, $category);
        $category->save();

        return $category;
    }

    public function delete(VacancyCategory $category): void
    {
        $category->delete();
    }

    protected function addTranslations(VacancyCategoryDTO $payload, VacancyCategory $category): VacancyCategory
    {
        return $category->setTranslations('name', $payload->name);
    }
}
