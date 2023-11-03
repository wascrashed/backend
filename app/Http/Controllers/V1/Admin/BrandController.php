<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\ErrorResponse;
use App\Http\Responses\SuccessEmptyResponse;
use App\Http\Responses\SuccessResponse;
use App\Tbuy\Attributable\Requests\ExtendNameRequest;
use App\Tbuy\Attributable\Requests\SetAttributeRequest;
use App\Tbuy\Brand\Models\Brand;
use App\Tbuy\Brand\Requests\AttachProductRequest;
use App\Tbuy\Brand\Requests\BrandFilterRequest;
use App\Tbuy\Brand\Requests\SetStatusRequest;
use App\Tbuy\Brand\Requests\StoreRequest;
use App\Tbuy\Brand\Requests\UpdateRequest;
use App\Tbuy\Brand\Resources\BrandResource;
use App\Tbuy\Brand\Services\BrandService;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Админ
 * @subgroup Бренд
 * @authenticated
 */
class BrandController extends Controller
{
    public function __construct(private readonly BrandService $brandService)
    {
    }

    /**
     * Список
     *
     * @queryParam brand_id int ID бренда. Example: 1
     * @queryParam date datetime Фильтрация по дате. Example: 2023-01-10
     * @queryParam company int Фильтрация по компании, надо передать ID компании. Example: 1
     * @queryParam category int Фильтрация по категориям, надо передать ID категории. Example: 2
     * @queryParam status string Фильтрация по статусу accepted, rejected и pending.
     * @responseFile storage/responses/brand/index.json
     * @param BrandFilterRequest $request
     * @return SuccessResponse
     */
    public function index(BrandFilterRequest $request): SuccessResponse
    {
        $brands = $this->brandService->get($request->toDto());

        return new SuccessResponse(
            response: BrandResource::collection($brands),
            message: "Brand list");
    }

    /**
     * Новый бренд
     *
     * @bodyParam name string required Название бренда. Example: Adidas
     * @bodyParam description object required Описание бренда
     * @bodyParam description.ru string required Описание на русском. Example: Описание
     * @bodyParam description.en string required Описание на английском. Example: Description
     * @bodyParam description.hy string required Описание на армянском. Example: Description
     * @bodyParam company_id integer ID required компании. Example: 1
     * @bodyParam country_id integer ID required страны. Example: 1
     * @bodyParam date string required Дата. Example: 2023-06-05
     * @bodyParam logo file required Логотип бренда (jpg,png)
     * @bodyParam certificate file required Подтверждающий сертификат (pdf)
     * @responseFile status=201 storage/responses/brand/create.json
     * @responseFile status=422 scenario="Validation failed" storage/responses/brand/validation-failed.json
     * @param StoreRequest $request
     * @return SuccessResponse
     */
    public function store(StoreRequest $request): SuccessResponse
    {
        $brand = $this->brandService->create($request->toDto());

        return new SuccessResponse(
            response: BrandResource::make($brand),
            status: Response::HTTP_CREATED,
            message: "Brand created"
        );
    }

    /**
     * Прикрепить продукт
     *
     * @urlParam brand_id int required ID бренда. Example: 1
     * @bodyParam product int[] required Список продуктов
     * @bodyParam product.0 integer required ID продукта. Example: 1
     * @response status=201 {"success": true, "message": "Brand attached product"}
     * @responseFile status=422 scenario="Validation failed" storage/responses/brand/product-validation-failed.json
     * @param AttachProductRequest $request
     * @param Brand $brand
     * @return SuccessEmptyResponse
     */
    public function attach(AttachProductRequest $request, Brand $brand): SuccessEmptyResponse
    {
        $this->brandService->attachProducts($brand, $request->toDto());

        return new SuccessEmptyResponse(
            message: "Brand attached product",
            status: Response::HTTP_CREATED
        );
    }

    /**
     * Детальная информация
     *
     * @urlParam id integer required ID бренда. Example: 1
     * @responseFile storage/responses/brand/show.json
     * @param Brand $brand
     * @return SuccessResponse
     */
    public function show(Brand $brand): SuccessResponse
    {
        return new SuccessResponse(
            response: BrandResource::make($brand->load([
                'attributesList',
                'company.brandDocument',
                'country',
                'products',
                'logo',
                'rejections.reason'
            ])),
            message: "Brand detail"
        );
    }

    /**
     * Изменение бренда
     *
     * @urlParam id integer required ID бренда. Example: 1
     * @bodyParam name string required Название бренда. Example: Adidas
     * @bodyParam description object required Описание бренда
     * @bodyParam description.ru string required Описание на русском. Example: Описание
     * @bodyParam description.en string required Описание на английском. Example: Description
     * @bodyParam description.hy string required Описание на армянском. Example: Description
     * @bodyParam company_id integer ID required компании. Example: 1
     * @bodyParam country_id integer ID required страны. Example: 1
     * @bodyParam date string required Дата. Example: 2023-06-05
     * @bodyParam logo file Логотип бренда (jpg,png)
     * @bodyParam certificate required Подтверждающий сертификат
     * @responseFile status=200 storage/responses/brand/update.json
     * @responseFile status=422 scenario="Validation failed" storage/responses/brand/validation-failed.json
     * @param UpdateRequest $request
     * @param Brand $brand
     * @return SuccessResponse
     */
    public function update(UpdateRequest $request, Brand $brand): SuccessResponse
    {
        $brand = $this->brandService->update($brand, $request->toDto());

        return new SuccessResponse(
            response: BrandResource::make($brand),
            message: "Brand updated"
        );
    }

    /**
     * Изменить статус
     *
     * @urlParam brand_id integer required ID бренда. Example: 1
     * @bodyParam status string required <br/>
     * <b>accepted</b> - подтверждено <br/>
     * <b>pending</b> - в ожидании <br/>
     * <b>rejected</b> - отказано <br/>
     * Example: accepted
     * @bodyParam reason_id int ID причины отказа, обязательно когда статус - <b>rejected</b>. Example: 3
     * @responseFile storage/responses/brand/update-status.json
     * @responseFile status=422 scenario="Validation failed" storage/responses/brand/update-status-failed.json
     * @param SetStatusRequest $request
     * @param Brand $brand
     * @return SuccessResponse
     */
    public function setStatus(SetStatusRequest $request, Brand $brand): SuccessResponse
    {
        $brand = $this->brandService->setStatus($brand, $request->toDTO(), auth()->id());

        return new SuccessResponse(
            response: BrandResource::make($brand),
            message: "Brand status updated"
        );
    }

    /**
     * Удаление бренда
     *
     * @urlParam id integer required ID бренда. Example: 1
     * @responseFile status=200 storage/responses/brand/destroy.json
     * @responseFile status=403 storage/responses/brand/destroy-failed.json
     * @param Brand $brand
     * @return SuccessEmptyResponse|ErrorResponse
     */
    public function destroy(Brand $brand): SuccessEmptyResponse|ErrorResponse
    {
        if ($this->brandService->delete($brand)) {
            return new SuccessEmptyResponse(
                message: "Бренд удален"
            );
        }

        return new ErrorResponse(
            message: "Невозможно удалить бренд, так как у него есть связанные элементы. Сначала удалите все связанное с данным брендом",
            status: 403
        );
    }

    /**
     * Привязка атрибутов
     *
     * @urlParam brand_id int required ID бренда. Example: 1
     * @bodyParam attribute object[] required Список атрибутов
     * @bodyParam attribute.0 object required Данные атрибутов
     * @bodyParam attribute.0.id int required ID атрибута. Example: 1
     * @bodyParam attribute.0.value int required ID значения атрибута. Example: 1
     * @bodyParam attribute.0.is_name_part bool required Будет ли стоять возле названия бренда. Example: true
     * @responseFile status=201 storage/responses/brand/set-attribute.json
     * @param SetAttributeRequest $request
     * @param Brand $brand
     * @return SuccessResponse
     */
    public function setAttribute(SetAttributeRequest $request, Brand $brand): SuccessResponse
    {
        $brand = $this->brandService->setAttribute($brand, $request->toCollection());

        return new SuccessResponse(
            response: BrandResource::make($brand),
            status: Response::HTTP_CREATED,
            message: "Атрибуты успешно подключены"
        );
    }

    /**
     * Расширение названия атрибутами
     *
     * АПИ поможет для управления расширениями названий с помощью атрибутов
     *
     * @urlParam brand_id int required ID бренда. Example: 1
     * @bodyParam attributes array required Список атрибутов
     * @bodyParam attributes.0 array required Объект атрибутов
     * @bodyParam attributes.0.attribute_id int required ID атрибута. Example: 1
     * @bodyParam attributes.0.is_name_part boolean Флаг для расширения названия текущим атрибутом.<br/>
     * <b>true</b> - добавит атрибут в название <br/>
     * <b>false</b> - уберёт атрибут из названия <br/>
     * Example: true
     * @param ExtendNameRequest $request
     * @param Brand $brand
     * @return SuccessResponse
     */
    public function extendName(ExtendNameRequest $request, Brand $brand): SuccessResponse
    {
        $brand = $this->brandService->extendName($brand, $request->toCollection());

        return new SuccessResponse(
            response: BrandResource::make($brand),
            message: "Название успешно расширены"
        );
    }
}
