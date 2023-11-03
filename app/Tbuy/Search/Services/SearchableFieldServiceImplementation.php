<?php

namespace App\Tbuy\Search\Services;

use App\Tbuy\Search\DTOs\SearchableFieldDTO;
use App\Tbuy\Search\Enums\CacheKey;
use App\Tbuy\Search\Model\SearchableField;
use App\Tbuy\Search\Repositories\SearchableFieldRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class SearchableFieldServiceImplementation implements SearchableFieldService
{
    private SearchableFieldRepository $searchableFieldRepository;

    public function __construct(SearchableFieldRepository $searchableFieldRepository)
    {
        $this->searchableFieldRepository = $searchableFieldRepository;
    }

    public function get(): Collection
    {
        return Cache::remember(CacheKey::SEARCHABLE_FIELD->value, CacheKey::ttl(), function () {
            return $this->searchableFieldRepository->get();
        });

    }

    public function store(SearchableFieldDTO $dto): SearchableField
    {
        $searchField = $this->searchableFieldRepository->store($dto);

        Cache::forget(CacheKey::SEARCHABLE_FIELD->value);

        return $searchField;
    }

    public function update(SearchableField $searchableField, SearchableFieldDTO $dto): SearchableField
    {
        $searchField = $this->searchableFieldRepository->update($searchableField, $dto);

        Cache::forget(CacheKey::SEARCHABLE_FIELD->value);

        return $searchField;
    }

    public function delete(SearchableField $searchableField): void
    {
        $this->searchableFieldRepository->delete($searchableField);
    }
}
