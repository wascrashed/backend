<?php

namespace App\Tbuy\Search\Services;

use App\Contracts\SearchableContract;
use App\Tbuy\Bank\Models\Bank;
use App\Tbuy\Category\Models\Category;
use App\Tbuy\Globals;
use App\Tbuy\Search\DTOs\SearchableModelDTO;
use App\Tbuy\Search\Enums\CacheKey;
use App\Tbuy\Search\Model\SearchableModel;
use App\Tbuy\Search\Repositories\SearchableModelRepository;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SearchableModelServiceImplementation implements SearchableModelService
{
    private SearchableModelRepository $searchableModelRepository;

    public function __construct(SearchableModelRepository $searchableModelRepository)
    {
        $this->searchableModelRepository = $searchableModelRepository;
    }

    public function get(string $search): Collection
    {
//            return Cache::remember(CacheKey::SEARCHABLE_MODEL->value, CacheKey::ttl(), function () {
        $models = config('search-ratings.models');
        $inputModels = SearchableModel::query()->with('modelList')
            ->whereHas('modelList', fn(Builder $q) => $q->whereIn('model', $models))
            ->orderBy('priority', 'desc')->get();
//                $inputModels = $this->searchableModelRepository->get();

        // Находим сумму всех приоритетов (20)
        $prioritiesCount = $inputModels->sum('priority');
        // Берём процент выдачи на единицу приоритета (1 / 20 = 0.05)
        $onePriority = 1 / $prioritiesCount;
        // Колличество эллементов в выдаче (20)
        $outputCount = Globals::OUTPUT_COUNT;
        // Результат выдачи
        $outputCollection = new Collection();

        // Если где-то мы не доберём до нужного колличества, мы скажем на следующей итерации дать больший приоритет другой моделе
        $limitOffset = 0;
        foreach ($inputModels as $model) {
            $modelClass = $model->modelList->model;

            $priority = $model->priority; // 8
            // Считаем приоритет для текущей моделе
            // (0.4 = 8 * 0.05)
            $percentPerModel = $priority * $onePriority;
            // 8 = 20 * 0.4
            $outputModelCount = ceil($percentPerModel * $outputCount);
            // Достаём модели
            $result = $modelClass::search($search)->get()->take($outputModelCount + $limitOffset);
            // Добавляем в результат
            $outputCollection = $outputCollection->merge($result);
            // Если не добрали нужное колличество результатов
            $resultsCount = $result->count();
            // Отнимаем от ожидаемого колличества результатов реальное колличество
            $limitOffset = abs($outputModelCount - $resultsCount);
        }
        return $outputCollection;
//            });
    }

    public function store(SearchableModelDTO $dto): SearchableModel
    {
        $searchModel = $this->searchableModelRepository->store($dto);

        Cache::forget(CacheKey::SEARCHABLE_MODEL->value);

        return $searchModel;
    }

    public function update(SearchableModel $searchableModel, SearchableModelDTO $dto): SearchableModel
    {
        $searchableModel = $this->searchableModelRepository->update($searchableModel, $dto);

        Cache::forget(CacheKey::SEARCHABLE_MODEL->value);

        return $searchableModel;
    }

    public function delete(SearchableModel $searchableModel): void
    {
        $this->searchableModelRepository->delete($searchableModel);
    }
}
