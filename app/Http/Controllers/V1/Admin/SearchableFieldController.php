<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\SuccessEmptyResponse;
use App\Http\Responses\SuccessResponse;
use App\Tbuy\Search\Model\SearchableField;
use App\Tbuy\Search\Requests\StoreRequestField;
use App\Tbuy\Search\Requests\UpdateRequestField;
use App\Tbuy\Search\Resources\SearchFieldResource;
use App\Tbuy\Search\Services\SearchableFieldService;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Поиск
 * @subgroup Поле для поиска
 * @authenticated
 */
class SearchableFieldController extends Controller
{
    public function __construct(private readonly SearchableFieldService $searchableFieldService)
    {
    }

    /**
     * Получение поля для поиска
     *
     * @responseFile storage/responses/search/indexSearchableField.json
     * @return SuccessResponse
     */
    public function index(): SuccessResponse
    {
        $searchField = $this->searchableFieldService->get();

        return new SuccessResponse(
            response: SearchFieldResource::collection($searchField),
            message: "Searchable field list"
        );
    }

    /**
     * Создание поля для поиска
     *
     * @bodyParam model_field_id integer ID ID поля модели. Example: 1
     * @bodyParam searchable_model_id integer ID required ID модели поиска. Example: 1
     * @bodyParam priority integer required Приоритет. Example: 1
     * @responseFile status=201 storage/responses/search/storeSearchableField.json
     * @responseFile status=422 scenario="Validation failed" storage/responses/search/validation-failed-SearchableField.json
     * @param StoreRequestField $request
     * @return SuccessResponse
     */
    public function store(StoreRequestField $request): SuccessResponse
    {
        $searchField = $this->searchableFieldService->store($request->toDto());

        return new SuccessResponse(
            response: SearchFieldResource::make($searchField->load(['modelField', 'searchableModel'])),
            status: Response::HTTP_CREATED,
            message: "Searchable field created"
        );
    }

    /**
     * Детали поля для поиска
     *
     * @urlParam id integer ID required ID поля для поиска. Example: 1
     * @responseFile storage/responses/search/showSearchableField.json
     * @param SearchableField $searchableField
     * @return SuccessResponse
     */
    public function show(SearchableField $searchableField): SuccessResponse
    {
        return new SuccessResponse(
            response: SearchFieldResource::make($searchableField->load(['modelField', 'searchableModel'])),
            message: "Searchable field detail"
        );
    }

    /**
     * Обновление данных поля для поиска
     *
     * @urlParam id integer required ID полей для поиска. Example: 1
     * @bodyParam model_field_id integer ID required ID поля модели. Example: 1
     * @bodyParam searchable_model_id integer ID required ID модели поиска. Example: 1
     * @bodyParam priority integer required Приоритет. Example: 1
     * @responseFile status=201 storage/responses/search/updateSearchableField.json
     * @responseFile status=422 scenario="Validation failed" storage/responses/search/validation-failed-SearchableField.json
     * @param UpdateRequestField $request
     * @param SearchableField $searchableField
     * @return SuccessResponse
     */
    public function update(UpdateRequestField $request, SearchableField $searchableField): SuccessResponse
    {
        $searchableField = $this->searchableFieldService->update($searchableField, $request->toDto());

        return new SuccessResponse(
            response: SearchFieldResource::make($searchableField->load(['modelField', 'searchableModel'])),
            message: "Searchable field update"
        );
    }

    /**
     * Удаление поля для поиска
     *
     * @urlParam id integer required ID поля для поиска. Example: 1
     * @responseFile status=200 storage/responses/search/destroySearchableField.json
     * @param SearchableField $searchableField
     * @return SuccessEmptyResponse
     */
    public function destroy(SearchableField $searchableField): SuccessEmptyResponse
    {
        $this->searchableFieldService->delete($searchableField);

        return new SuccessEmptyResponse(
            message: "Searchable field deleted"
        );
    }
}
