<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\SuccessEmptyResponse;
use App\Http\Responses\SuccessResponse;
use App\Tbuy\Attribute\Models\Attribute;
use App\Tbuy\Attribute\Requests\StoreRequest;
use App\Tbuy\Attribute\Requests\UpdateRequest;
use App\Tbuy\Attribute\Resources\AttributeResource;
use App\Tbuy\Attribute\Services\AttributeService;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Админ
 * @subgroup Атрибуты
 * @authenticated
 */
class AttributeController extends Controller
{
    public function __construct(private readonly AttributeService $attributeService)
    {
    }

    /**
     * Список
     *
     * @queryParam all bool Выборка атрибутов во всех языках. Example: true
     * @responseFile storage/responses/attribute/index.json
     * @responseFile scenario="Запрос с query запросом all=1" storage/responses/attribute/index-all.json
     * @return SuccessResponse
     */
    public function index(): SuccessResponse
    {
        $attributes = $this->attributeService->get();

        return new SuccessResponse(
            response: AttributeResource::collection($attributes),
            message: 'Attribute list'
        );
    }

    /**
     * Создать
     *
     * @bodyParam name object required Название
     * @bodyParam name.ru string required Название на русском. Example: some-name
     * @bodyParam name.en string required Название на английском. Example: some-name
     * @bodyParam name.hy string required Название на армянском. Example: some-name
     * @responseFile status=201 storage/responses/attribute/create.json
     * @responseFile status=422 scenario="Validation failed" storage/responses/attribute/validation-failed.json
     * @param StoreRequest $request
     * @return SuccessResponse
     */
    public function store(StoreRequest $request): SuccessResponse
    {
        $attribute = $this->attributeService->create($request->toDto());

        return new SuccessResponse(
            response: AttributeResource::make($attribute),
            status: Response::HTTP_CREATED,
            message: 'Attribute created'
        );
    }

    /**
     * Изменить
     *
     * @urlParam id int required ID атрибута Example: 1
     * @bodyParam name object required Название
     * @bodyParam name.ru string required Название на русском. Example: some-name
     * @bodyParam name.en string required Название на английском. Example: some-name
     * @bodyParam name.hy string required Название на армянском. Example: some-name
     * @responseFile storage/responses/attribute/update.json
     * @responseFile status=422 scenario="Validation failed" storage/responses/attribute/validation-failed.json
     * @param UpdateRequest $request
     * @param Attribute $attribute
     * @return SuccessResponse
     */
    public function update(UpdateRequest $request, Attribute $attribute): SuccessResponse
    {
        $attribute = $this->attributeService->update($attribute, $request->toDto());

        return new SuccessResponse(
            response: AttributeResource::make($attribute),
            message: 'Attribute updated'
        );
    }

    /**
     * Удалить
     *
     * @urlParam id integer required ID атрибута. Example :1
     * @responseFile storage/responses/attribute/delete.json
     * @param Attribute $attribute
     * @return SuccessEmptyResponse
     */
    public function destroy(Attribute $attribute): SuccessEmptyResponse
    {
        $this->attributeService->delete($attribute);

        return new SuccessEmptyResponse(
            message: "Attribute deleted"
        );
    }
}
