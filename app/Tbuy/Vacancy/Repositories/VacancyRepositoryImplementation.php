<?php

namespace App\Tbuy\Vacancy\Repositories;

use App\Tbuy\Vacancy\DTOs\VacancyDTO;
use App\Tbuy\Vacancy\Models\Vacancy;
use Illuminate\Database\Eloquent\Collection;

class VacancyRepositoryImplementation implements VacancyRepository
{

    public function get(): Collection
    {
        return Vacancy::query()
            ->with(['category', 'tags', 'images'])
            ->get();
    }

    public function create(VacancyDTO $payload): Vacancy
    {
        $vacancy = new Vacancy([
            'category_id' => $payload->category_id,
            'salary' => $payload->salary
        ]);

        $vacancy = $this->addTranslations($payload, $vacancy);
        $vacancy->save();
        $vacancy = $this->addTags($payload, $vacancy);

        return $vacancy;
    }

    public function update(VacancyDTO $payload, Vacancy $vacancy): Vacancy
    {
        $vacancy->fill([
            'category_id' => $payload->category_id ?? $vacancy->category_id,
            'salary' => $payload->salary ?? $vacancy->salary
        ]);

        $vacancy = $this->addTranslations($payload, $vacancy);
        $vacancy->save();
        $vacancy = $this->addTags($payload, $vacancy);

        return $vacancy;
    }

    public function delete(Vacancy $vacancy): void
    {
        $vacancy->delete();
    }

    protected function addTranslations(VacancyDTO $payload, Vacancy $vacancy): Vacancy
    {
        if ($payload->title || $payload->description) {
            $vacancy
                ->setTranslations('title', $payload->title)
                ->setTranslations('description', $payload->description);
        }

        return $vacancy;
    }

    protected function addTags(VacancyDTO $payload, Vacancy $vacancy): Vacancy
    {
        if ($payload->tags) {
            $vacancy->attachTags($payload->tags);
        }

        return $vacancy;
    }
}
