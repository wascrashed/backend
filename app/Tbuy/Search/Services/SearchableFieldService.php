<?php

namespace App\Tbuy\Search\Services;

use App\Tbuy\Search\DTOs\SearchableFieldDTO;
use App\Tbuy\Search\Model\SearchableField;
use Illuminate\Database\Eloquent\Collection;

interface SearchableFieldService
{
    public function get(): Collection;

    public function store(SearchableFieldDTO $dto): SearchableField;

    public function update(SearchableField $searchableField, SearchableFieldDTO $dto): SearchableField;

    public function delete(SearchableField $searchableField): void;
}
