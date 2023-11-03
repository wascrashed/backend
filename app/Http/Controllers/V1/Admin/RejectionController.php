<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\SuccessResponse;
use App\Tbuy\Rejection\Models\Rejection;
use App\Tbuy\Rejection\Requests\RejectionsUpdateRequest;
use App\Tbuy\Rejection\Resources\RejectionResource;
use App\Tbuy\Rejection\Requests\IndexRejectionsRequest;
use App\Tbuy\Rejection\Services\RejectionService;

/**
 * @group Админ
 * @subgroup Архив отклонений
 * @authenticated
 */
class RejectionController extends Controller
{
    public function __construct(private readonly RejectionService $rejectionService)
    {
    }

    /**
     * Список отказов
     *
     * @queryParam type string required Тип отказываемой сущности. <br/>
     * <b>brand</b> - для отклонённых брендов <br/>
     * <b>company</b> - для отклонённых компаний <br/>
     * <b>product</b> - для отклонённых продуктов. <br/>
     * Example: brand
     * @queryParam reason int[] Список ID причин отказов.
     * @queryParam reason.0 int ID причины отказа. Example: 1
     * @queryParam id int ID сущности. Example: 1
     * @queryParam user int ID отказавшегося пользователя. Example: 1
     * @queryParam date string Дата создания бренда </br>
     * Формат <b>Y-m-d</b> <br/>
     * Работает когда <b>type=brand</b>.<br/>
     * Example: 2023-01-01
     * @queryParam name string Название бренда </br>
     * Работает когда <b>type=brand</b>.<br/>
     * Example: Адидас
     * @queryParam company int ID компании которое принадлежит бренд </br>
     * @queryParam category_id int ID категории которое принадлежит бренду </br>
     * Работает когда <b>type=brand</b>.<br/>
     * Example: 1
     * @responseFile status=200 scenario="Отказанные бренды" storage/responses/rejection/index-brand.json
     * @responseFile status=200 scenario="Отказанные компании" storage/responses/rejection/index-company.json
     * @responseFile status=200 scenario="Отказанные продукты" storage/responses/rejection/index-product.json
     * @param IndexRejectionsRequest $request
     * @return SuccessResponse
     */
    public function index(IndexRejectionsRequest $request): SuccessResponse
    {
        $rejections = $this->rejectionService->get($request->toDto());

        return new SuccessResponse(
            response: RejectionResource::collection($rejections),
            message: 'Rejection list'
        );
    }

    /**
     * Изменение отказа
     *
     * @urlParam rejection int ID отклонения для обновления
     * @bodyParam reason_id int ID причины, на который будет заменен причина отказа
     *
     * @param Rejection $rejection
     * @param RejectionsUpdateRequest $request
     * @return SuccessResponse
     */
    public function update(Rejection $rejection, RejectionsUpdateRequest $request): SuccessResponse
    {
        $rejection = $this->rejectionService->update($rejection, $request->toDto());

        return new SuccessResponse(
            response: RejectionResource::make($rejection),
            message: 'Успушно обновлено'
        );
    }
}
