<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\SuccessEmptyResponse;
use App\Http\Responses\SuccessResponse;
use App\Tbuy\AttributeValue\Models\AttributeValue;
use App\Tbuy\AttributeValue\Requests\StoreRequest;
use App\Tbuy\AttributeValue\Requests\UpdateRequest;
use App\Tbuy\AttributeValue\Resources\AttributeValueResource;
use App\Tbuy\AttributeValue\Services\AttributeValueService;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Админ
 * @subgroup Значения атрибутов
 * @subgroup
 */
class AttributeValueController extends Controller
{
    public function __construct(
        private readonly AttributeValueService $valueService
    )
    {
    }

    /**
     * Создать
     *
     * @bodyParam name object required Значение
     * @bodyParam name.ru string required Значение на русском. Example: some-value
     * @bodyParam name.en string required Значение на английском. Example: some-value
     * @bodyParam name.hy string required Значение на армянском. Example: some-value
     * @bodyParam attribute_id integer required ID атрибута. Example: 1
     * @responseFile status=201 storage/responses/attribute/value/create.json
     * @responseFile status=422 scenario="Validation-failed" storage/responses/attribute/value/validation-failed.json
     * @param StoreRequest $request
     * @return SuccessResponse
     */
    public function store(StoreRequest $request): SuccessResponse
    {
        $value = $this->valueService->create($request->toDto());

        return new SuccessResponse(
            response: AttributeValueResource::make($value),
            status: Response::HTTP_CREATED,
            message: 'Attribute value created'
        );
    }

    /**
     * Изменить
     *
     * @urlParam value_id int required ID значения атрибута. Example: 1
     * @bodyParam name object required Значение
     * @bodyParam name.ru string required Значение на русском. Example: some-value
     * @bodyParam name.en string required Значение на английском. Example: some-value
     * @bodyParam name.hy string required Значение на армянском. Example: some-value
     * @bodyParam attribute_id integer required ID атрибута. Example: 1
     * @responseFile storage/responses/attribute/value/update.json
     * @responseFile status=422 scenario="Validation-failed" storage/responses/attribute/value/validation-failed.json
     * @param UpdateRequest $request
     * @param AttributeValue $value
     * @return SuccessResponse
     */
    public function update(UpdateRequest $request, AttributeValue $value): SuccessResponse
    {
        $value = $this->valueService->update($value, $request->toDto());

        return new SuccessResponse(
            response: AttributeValueResource::make($value),
            message: 'Attribute value updated'
        );
    }

    /**
     * Удалить
     *
     * @urlParam value_id int required ID значения атрибута. Example: 1
     * @response {"success": true, "message": "Attribute value deleted"}
     * @param AttributeValue $value
     * @return SuccessEmptyResponse
     */
    public function destroy(AttributeValue $value): SuccessEmptyResponse
    {
        $this->valueService->delete($value);

        return new SuccessEmptyResponse(
            message: "Attribute value deleted"
        );
    }
}
