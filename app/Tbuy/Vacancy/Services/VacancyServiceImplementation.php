<?php

namespace App\Tbuy\Vacancy\Services;

use App\Tbuy\MediaLibrary\Enums\MediaLibraryCollection;
use App\Tbuy\MediaLibrary\Repositories\MediaLibraryRepository;
use App\Tbuy\Vacancy\DTOs\VacancyDTO;
use App\Tbuy\Vacancy\Enums\VacancyCacheKey;
use App\Tbuy\Vacancy\Models\Vacancy;
use App\Tbuy\Vacancy\Repositories\VacancyRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class VacancyServiceImplementation implements VacancyService
{
    public function __construct(
        private readonly VacancyRepository      $vacancyRepository,
        private readonly MediaLibraryRepository $mediaLibraryRepository
    )
    {
    }

    public function get(): Collection
    {
        return Cache::tags(VacancyCacheKey::LIST->value)
            ->remember(
                VacancyCacheKey::LIST->value,
                VacancyCacheKey::ttl(),
                function () {
                    return $this->vacancyRepository->get();
                }
            );
    }

    public function create(VacancyDTO $payload): Vacancy
    {
        $vacancy = DB::transaction(function () use ($payload) {
            $vacancy = $this->vacancyRepository->create($payload);

            if ($payload->images) {
                $this->mediaLibraryRepository->addAllMedia($vacancy, $payload->images, MediaLibraryCollection::VACANCY_MEDIA);
            }

            return $vacancy->load(['category', 'tags', 'images']);
        });

        Cache::tags(VacancyCacheKey::LIST)->clear();

        return $vacancy;
    }

    public function update(VacancyDTO $payload, Vacancy $vacancy): Vacancy
    {
        $vacancy = DB::transaction(function () use ($payload, $vacancy) {
            $vacancy = $this->vacancyRepository->update($payload, $vacancy);

            if ($payload->images) {
                $allImages = $this->mediaLibraryRepository->getMedia($vacancy, MediaLibraryCollection::VACANCY_MEDIA);
                $newImageFileNames = array_column($payload->images, 'file_name');
                $existingImageFileNames = array_column($allImages->toArray(), 'file_name');

                foreach ($allImages as $image) {
                    if (in_array($image->file_name, $newImageFileNames) && in_array($image->file_name, $existingImageFileNames)) {
                        $this->mediaLibraryRepository->delete($vacancy, MediaLibraryCollection::VACANCY_MEDIA, $image->file_name);
                    }
                }

                $this->mediaLibraryRepository->addAllMedia($vacancy, $payload->images, MediaLibraryCollection::VACANCY_MEDIA);
            }

            return $vacancy->load(['category', 'tags', 'images']);
        });

        Cache::tags(VacancyCacheKey::LIST)->clear();

        return $vacancy;
    }

    public function delete(Vacancy $vacancy): void
    {
        $this->vacancyRepository->delete($vacancy);

        Cache::forget(VacancyCacheKey::LIST->value);
    }
}
