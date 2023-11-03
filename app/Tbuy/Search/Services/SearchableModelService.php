<?php

namespace App\Tbuy\Search\Services;

use App\Tbuy\Search\DTOs\SearchableModelDTO;
use App\Tbuy\Search\Model\SearchableModel;
use Illuminate\Database\Eloquent\Collection;

interface SearchableModelService
{
    public function get(string $search): Collection;

    public function store(SearchableModelDTO $dto): SearchableModel;

    public function update(SearchableModel $searchableModel, SearchableModelDTO $dto): SearchableModel;

    public function delete(SearchableModel $searchableModel): void;
}
