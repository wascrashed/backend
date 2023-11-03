<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\SuccessResponse;
use App\Tbuy\Attributable\Requests\ExtendNameRequest;
use App\Tbuy\Attributable\Requests\SetAttributeRequest;
use App\Tbuy\Product\Models\Product;
use App\Tbuy\Product\Repositories\ProductRepository;
use App\Tbuy\Product\Requests\ProductFilterRequest;
use App\Tbuy\Product\Requests\ToggleStatusRequest;
use App\Tbuy\Product\Requests\UpdateRequest;
use App\Tbuy\Product\Resources\ProductResource;
use App\Tbuy\Product\Services\ProductService;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Админ
 * @subgroup Продукты
 * @authenticated
 */
class ProductController extends Controller
{
    public function __construct(
        protected readonly ProductService    $productService,
        protected readonly ProductRepository $productRepository
    )
    {
    }

    /**
     * Список с фильтрами
     *
     * @responseFile storage/responses/product/index/index.json
     * @responseFile status=422 scenario="Validation failed" storage/responses/product/index/fail.json
     * @queryParam from date required_with:to Example: 2023-01-01
     * @queryParam to date required_with:from Example: 2023-01-10
     * @queryParam last_accept boolean nullable Когда true или false возвращает последние 100 подтвержденных или не подтвержденных продуктов
     * @queryParam name string Example: apple
     * @queryParam id int ID Продукта, Example: 1
     * @queryParam category_id int ID Категории
     * @queryParam company_id int ID Компании
     * @queryParam status string Есть три типа статуса это confirmed, rejected, need_update, waiting Example: rejected
     * @queryParam active boolean Фильтрация по активности и не активности продукта Example: true
     * @queryParam before_declined boolean Было ли раньше отменено
     * @queryParam before_accepted boolean Было ли раньшн подтверждено
     * @queryParam before_declined_reasons boolean Было ли раньше отклонен, причины
     * @queryParam zero_amount boolean Возвращает продукты с нулевым количеством
     * @queryParam reason_id int ID причины отклонения
     * @param ProductFilterRequest $request
     * @return SuccessResponse
     */
    public function index(ProductFilterRequest $request): SuccessResponse
    {
        $products = $this->productService->get($request->toDto(), [
            'attributesList',
            'brand.attributesList',
            'brand.company',
            'brand.country',
            'category',
            'rejections.reason',
            'mainImage',
            'images'
        ]);

        return new SuccessResponse(
            response: ProductResource::collection($products),
            message: 'Список отфильтрованных продуктов'
        );
    }

    /**
     * Информация о продукте
     *
     * @urlParam product integer required ID продукта. Example: 1
     * @responseFile storage/responses/product/show.json
     * @param Product $product
     * @return SuccessResponse
     */
    public function show(Product $product): SuccessResponse
    {
        return new SuccessResponse(
            response: ProductResource::make($product->load([
                'attributesList',
                'brand.attributesList',
                'brand.company',
                'brand.country',
                'category',
                'rejections.reason',
                'mainImage',
                'images'
            ])),
            message: 'Полная информация о продукте'
        );
    }

    /**
     * Редактирование продукта
     *
     * @bodyParam images array Массив с изображениям продукта
     * @bodyParam category_id int ID категории продукта
     * @bodyParam amount float Количество продукта. Example: 12.23
     * @bodyParam price float Цена продукта. Example: 3200.00
     * @bodyParam type string Тип продукта. Есть два типа: default, gift_card. Example: gift_card
     * @bodyParam active bool Активность и неактивность продукта. Example: 1
     * @bodyParam brand_id int Бренд продукта. Example: 1
     * @bodyParam description object Объект описания
     * @bodyParam description.ru object required Описание на русском. Example: some-description
     * @bodyParam description.en object required Описание на английском. Example: some-description
     * @bodyParam description.hy object required Описание на армянском. Example: some-description
     * @bodyParam visible_fields object required Объект видимых полей
     * @bodyParam visible_fields.0 string Название поля. Example: category_id
     * @responseFile storage/responses/product/update.json
     * @param UpdateRequest $request
     * @param Product $product
     * @return SuccessResponse
     */
    public function update(UpdateRequest $request, Product $product): SuccessResponse
    {
        $product = $this->productService->update($request->toDto(), $product);

        return new SuccessResponse(
            response: ProductResource::make($product),
            message: 'Продукт успешно обновлен'
        );
    }

    /**
     * Продукты с нулевым остатком
     *
     * @responseFile storage/responses/product/zero.json
     * @responseFile status=422 scenario="Validation failed" storage/responses/product/index/fail.json
     * @queryParam from date required_with:to Example: 2023-01-01
     * @queryParam to date required_with:from Example: 2023-01-10
     * @queryParam name string Example: apple
     * @queryParam id int ID Продукта, Example: 1
     * @queryParam category_id int ID Категории
     * @queryParam company_id int ID Компании
     * @queryParam before_declined boolean Было ли раньше отменено
     * @queryParam status string Статус продукта
     * @param ProductFilterRequest $request
     * @return SuccessResponse
     */
    public function indexZeroAmount(ProductFilterRequest $request): SuccessResponse
    {
        $products = $this->productService->getZeroAmount($request->toDto(), [
            'brand.company',
            'category',
            'rejections.reason'
        ]);

        return new SuccessResponse(
            response: ProductResource::collection($products),
            message: 'Список продуктов c нулевым остатком'
        );
    }

    /**
     * Изменить статус
     *
     * @urlParam product_id integer required ID продукта. Example: 1
     * @bodyParam status string required <br/>
     * <b>accepted</b> - подтверждено <br/>
     * <b>pending</b> - в ожидании <br/>
     * <b>rejected</b> - отказано <br/>
     * Example: accepted
     * @bodyParam reason_id int ID причины отказа, обязательно когда статус - <b>rejected</b>. Example: 3
     * @responseFile storage/responses/product/update-status.json
     * @responseFile status=422 scenario="Validation failed" storage/responses/product/update-status-failed.json
     * @param ToggleStatusRequest $request
     * @param Product $product
     * @return SuccessResponse
     */
    public function toggleStatus(ToggleStatusRequest $request, Product $product): SuccessResponse
    {
        $product = $this->productService->toggleStatus($product, $request->toDto());

        return new SuccessResponse(
            response: ProductResource::make($product),
            message: 'Статус продукта успешно изменен'
        );
    }

    /**
     * Привязка атрибутов
     *
     * @urlParam product_id int required ID продукта. Example: 1
     * @bodyParam attribute object[] required Список атрибутов
     * @bodyParam attribute.0 object required Данные атрибутов
     * @bodyParam attribute.0.id int required ID атрибута. Example: 1
     * @bodyParam attribute.0.value int required ID значения атрибута. Example: 1
     * @bodyParam attribute.0.is_name_part bool required Будет ли стоять возле названия продукта. Example: true
     * @param SetAttributeRequest $request
     * @param Product $product
     * @return SuccessResponse
     */
    public function setAttribute(SetAttributeRequest $request, Product $product): SuccessResponse
    {
        $product = $this->productService->setAttribute($product, $request->toCollection());

        return new SuccessResponse(
            response: ProductResource::make($product),
            status: Response::HTTP_CREATED,
            message: "Атрибуты успешно подключены"
        );
    }

    /**
     * Расширение названия атрибутами
     *
     * АПИ поможет для управления расширениями названий с помощью атрибутов
     *
     * @urlParam product_id int required ID продукта. Example: 1
     * @bodyParam attributes array required Список атрибутов
     * @bodyParam attributes.0 array required Объект атрибутов
     * @bodyParam attributes.0.attribute_id int required ID атрибута. Example: 1
     * @bodyParam attributes.0.is_name_part boolean Флаг для расширения названия текущим атрибутом.<br/>
     * <b>true</b> - добавит атрибут в название <br/>
     * <b>false</b> - уберёт атрибут из названия <br/>
     * Example: true
     * @param ExtendNameRequest $request
     * @param Product $product
     * @return SuccessResponse
     */
    public function extendName(ExtendNameRequest $request, Product $product): SuccessResponse
    {
        $this->productService->extendName($product, $request->toCollection());

        return new SuccessResponse(
            response: ProductResource::make($product),
            message: "Название успешно расширены"
        );
    }
}
