<?php

namespace App\Tbuy\Search\Repositories;

use App\Tbuy\Search\DTOs\SearchableFieldDTO;
use App\Tbuy\Search\Model\SearchableField;
use Illuminate\Database\Eloquent\Collection;

class SearchableFieldRepositoryImplementation implements SearchableFieldRepository
{

    public function get(): Collection
    {
        return SearchableField::with(['modelField', 'searchableModel'])->get();
    }

    public function store(SearchableFieldDTO $dto): SearchableField
    {
        return SearchableField::create($dto->toArray());
    }

    public function update(SearchableField $searchableField, SearchableFieldDTO $dto): SearchableField
    {
        $searchableField->update($dto->toArray());

        return $searchableField;
    }

    public function delete(SearchableField $searchableField): void
    {
        $searchableField->delete();
    }
}
