<?php

namespace App\Tbuy\Vacancy\Repositories\VacancyCategory;

use App\Tbuy\Vacancy\DTOs\VacancyCategoryDTO;
use App\Tbuy\Vacancy\Models\VacancyCategory;
use Illuminate\Database\Eloquent\Collection;

interface VacancyCategoryRepository
{
    public function get(): Collection;

    public function create(VacancyCategoryDTO $payload): VacancyCategory;

    public function update(VacancyCategoryDTO $payload, VacancyCategory $category): VacancyCategory;

    public function delete(VacancyCategory $category): void;
}
