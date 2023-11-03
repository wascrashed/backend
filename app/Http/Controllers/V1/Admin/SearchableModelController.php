<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\SuccessEmptyResponse;
use App\Http\Responses\SuccessResponse;
use App\Tbuy\Search\Model\SearchableModel;
use App\Tbuy\Search\Requests\SearchQueryRequest;
use App\Tbuy\Search\Requests\StoreRequestModel;
use App\Tbuy\Search\Requests\UpdateRequestModel;
use App\Tbuy\Search\Resources\SearchModelResource;
use App\Tbuy\Search\Services\SearchableModelService;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Поиск
 * @subgroup Модель для поиска
 * @authenticated
 */
class SearchableModelController extends Controller
{
    public function __construct(private readonly SearchableModelService $searchableModelService)
    {
    }

    /**
     * Получение модели для поиска
     *
     * @queryParam query string Текст запроса поиска. Example: request text
     * @responseFile storage/responses/search/indexSearchableModel.json
     * @param SearchQueryRequest $request
     * @return SuccessResponse
     */
    public function index(SearchQueryRequest $request): SuccessResponse
    {
        $searchModel = $this->searchableModelService->get($request->query('query', ''));

        return new SuccessResponse(
            response: SearchModelResource::collection($searchModel),
            message: "Searchable model list"
        );
    }

    /**
     * Создание модели для поиска
     *
     * @bodyParam model_id integer ID required ID модели для поиска. Example: 1
     * @bodyParam priority integer required приоритет. Example: 1
     * @bodyParam count integer required количество в выдаче. Example: 1
     * @responseFile status=201 storage/responses/search/storeSearchableModel.json
     * @responseFile status=422 scenario="Validation failed" storage/responses/search/validation-failed-SearchableModel.json
     * @param StoreRequestModel $request
     * @return SuccessResponse
     */
    public function store(StoreRequestModel $request): SuccessResponse
    {
        $searchModel = $this->searchableModelService->store($request->toDto());

        return new SuccessResponse(
            response: SearchModelResource::make($searchModel->load(['searchableFields', 'modelList'])),
            status: Response::HTTP_CREATED,
            message: "Searchable model created"
        );
    }

    /**
     * Детали модели для поиска
     *
     * @urlParam id integer ID required ID модели для поиска. Example: 1
     * @responseFile storage/responses/search/showSearchableModel.json
     * @param SearchableModel $searchableModel
     * @return SuccessResponse
     */
    public function show(SearchableModel $searchableModel): SuccessResponse
    {
        return new SuccessResponse(
            response: SearchModelResource::make($searchableModel->load(['searchableFields', 'modelList'])),
            message: "Searchable model detail"
        );
    }

    /**
     * Обновление данных модели для поиска
     *
     * @urlParam id integer required ID модели для поиска. Example: 1
     * @bodyParam model_id integer ID required ID модели для поиска. Example: 1
     * @bodyParam priority integer required приоритет. Example: 2
     * @bodyParam count integer required количество в выдаче. Example: 2
     * @responseFile status=201 storage/responses/search/updateSearchableModel.json
     * @responseFile status=422 scenario="Validation failed" storage/responses/search/validation-failed-SearchableModel.json
     * @param UpdateRequestModel $request
     * @param SearchableModel $searchableModel
     * @return SuccessResponse
     */
    public function update(UpdateRequestModel $request, SearchableModel $searchableModel): SuccessResponse
    {
        $searchableModel = $this->searchableModelService->update($searchableModel, $request->toDto());

        return new SuccessResponse(
            response: SearchModelResource::make($searchableModel->load(['searchableFields', 'modelList'])),
            message: "Searchable model update"
        );
    }

    /**
     * Удаление модели для поиска
     *
     * @urlParam id integer ID required ID модели для поиска. Example: 1
     * @responseFile status=200 storage/responses/search/destroySearchableModel.json
     * @param SearchableModel $searchableModel
     * @return SuccessEmptyResponse
     */
    public function destroy(SearchableModel $searchableModel): SuccessEmptyResponse
    {
        $this->searchableModelService->delete($searchableModel);

        return new SuccessEmptyResponse(
            message: "Searchable model deleted"
        );
    }
}
