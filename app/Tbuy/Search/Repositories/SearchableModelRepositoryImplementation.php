<?php

namespace App\Tbuy\Search\Repositories;

use App\Tbuy\Search\DTOs\SearchableModelDTO;
use App\Tbuy\Search\Model\SearchableModel;
use Illuminate\Database\Eloquent\Collection;

class SearchableModelRepositoryImplementation implements SearchableModelRepository
{

    public function get(): Collection
    {
        return SearchableModel::with('modelList', 'searchableFields')->get();
    }

    public function store(SearchableModelDTO $dto): SearchableModel
    {
        $attributes = [
            'model_id' => $dto->model_id,
            'priority' => $dto->priority,
            'count' => $dto->count,
        ];

        return SearchableModel::create($attributes);
    }

    public function update(SearchableModel $searchableModel, SearchableModelDTO $dto): SearchableModel
    {
        $attributes = [
            'model_id' => $dto->model_id,
            'priority' => $dto->priority,
            'count' => $dto->count,
        ];

        $searchableModel->update($attributes);

        return $searchableModel;
    }

    public function delete(SearchableModel $searchableModel): void
    {
        $searchableModel->delete();
    }
}
