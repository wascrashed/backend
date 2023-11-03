<?php

namespace App\Tbuy\Vacancy\Services;

use App\Tbuy\Vacancy\DTOs\VacancyDTO;
use App\Tbuy\Vacancy\Models\Vacancy;
use Illuminate\Database\Eloquent\Collection;

interface VacancyService
{
    public function get(): Collection;

    public function create(VacancyDTO $payload): Vacancy;

    public function update(VacancyDTO $payload, Vacancy $vacancy): Vacancy;

    public function delete(Vacancy $vacancy): void;
}
