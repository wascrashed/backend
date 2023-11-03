<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\SuccessEmptyResponse;
use App\Http\Responses\SuccessResponse;
use App\Tbuy\Tariff\Models\Tariff;
use App\Tbuy\Tariff\Requests\StoreRequest;
use App\Tbuy\Tariff\Requests\UpdateRequest;
use App\Tbuy\Tariff\Resources\TariffResource;
use App\Tbuy\Tariff\Services\TariffService;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Админ
 * @subgroup Тарифы (Админ)
 * @authenticated
 */
class TariffController extends Controller
{
    public function __construct(
        public readonly TariffService $tariffService
    )
    {
    }

    /**
     * Получение списка тарифов
     *
     * @responseFile storage/responses/tariff/index.json
     * @return SuccessResponse
     */
    public function index(): SuccessResponse
    {
        $tariffs = $this->tariffService->get();

        return new SuccessResponse(
            response: TariffResource::collection($tariffs),
            message: 'Список тарифов'
        );
    }

    /**
     * Создание тарифа
     *
     * @bodyParam name object required Объект названий тарифа.
     * @bodyParam name.ru string required Наименование на русском языке. Example: Test
     * @bodyParam name.en string required Наименование на английском языке. Example: Test
     * @bodyParam name.hy string required Наименование на армянском языке. Example: Test
     * @bodyParam description object required Объект описаний тарифа.
     * @bodyParam description.ru string required Описание на русском языке. Example: Test
     * @bodyParam description.en string required Описание на английском языке. Example: Test
     * @bodyParam description.hy string required Описание на армянском языке. Example: Test
     * @bodyParam privileges array required Список привилегий.
     * @bodyParam privileges.0 array required Объект привилегий.
     * @bodyParam privileges.0.name object required Текст привилегия.
     * @bodyParam privileges.0.name.ru string required Текст привилегия на русском языке. Example: Больше денег
     * @bodyParam privileges.0.name.en string required Текст привилегия на английском языке. Example: Больше денег
     * @bodyParam privileges.0.name.hy string required Текст привилегия на армянском языке. Example: Больше денег
     * @bodyParam price array required Список цен.
     * @bodyParam price.0 object required Список цен.
     * @bodyParam price.0.price float required Цена. Example: 5000
     * @bodyParam price.0.discount_price float Скидочная цена. Example: 2000
     * @bodyParam price.0.months int required Месяц. Example: 3
     * @bodyParam score required int Кол-во очков. Example: 20
     * @bodyParam percent required float Процент. Example: 0.25
     * @responseFile status=201 storage/responses/tariff/store.json
     * @responseFile status=422 scenario="Validation failed" storage/responses/tariff/validation-failed.json
     * @param StoreRequest $request
     * @return SuccessResponse
     */
    public function store(StoreRequest $request): SuccessResponse
    {
        return new SuccessResponse(
            response: new TariffResource(
                resource: $this->tariffService->create(
                    dto: $request->toDto()
                )
            ),
            status: Response::HTTP_CREATED,
            message: 'Тариф создан'
        );
    }

    /**
     * Получение деталей тарифа
     *
     * @urlParam id integer required ID тарифа. Example: 1
     * @responseFile storage/responses/tariff/show.json
     * @param Tariff $tariff
     * @return SuccessResponse
     */
    public function show(Tariff $tariff): SuccessResponse
    {
        return new SuccessResponse(
            response: new TariffResource($tariff->load('privileges')),
            message: 'Детали тарифа'
        );
    }

    /**
     * Обновление тарифа
     *
     * @urlParam id integer required ID тарифа. Example: 1
     * @bodyParam name object required Объект названий тарифа.
     * @bodyParam name.ru string required Наименование на русском языке. Example: Test
     * @bodyParam name.en string required Наименование на английском языке. Example: Test
     * @bodyParam name.hy string required Наименование на армянском языке. Example: Test
     * @bodyParam description object required Объект описаний тарифа.
     * @bodyParam description.ru string required Описание на русском языке. Example: Test
     * @bodyParam description.en string required Описание на английском языке. Example: Test
     * @bodyParam description.hy string required Описание на армянском языке. Example: Test
     * @bodyParam privileges array required Список привилегий.
     * @bodyParam privileges.0 array required Объект привилегий.
     * @bodyParam privileges.0.name object required Текст привилегия.
     * @bodyParam privileges.0.name.ru string required Текст привилегия на русском языке. Example: Больше денег
     * @bodyParam privileges.0.name.en string required Текст привилегия на английском языке. Example: Больше денег
     * @bodyParam privileges.0.name.hy string required Текст привилегия на армянском языке. Example: Больше денег
     * @bodyParam price array required Список цен.
     * @bodyParam price.0 object required Список цен.
     * @bodyParam price.0.price float required Цена. Example: 5000
     * @bodyParam price.0.discount_price float Скидочная цена. Example: 2000
     * @bodyParam price.0.months int required Месяц. Example: 3
     * @bodyParam score required int Кол-во очков. Example: 20
     * @bodyParam percent required float Процент. Example: 0.25
     * @responseFile status=200 storage/responses/tariff/update.json
     * @responseFile status=422 scenario="Validation failed" storage/responses/tariff/validation-failed.json
     * @param UpdateRequest $request
     * @param Tariff $tariff
     * @return SuccessResponse
     */
    public function update(UpdateRequest $request, Tariff $tariff): SuccessResponse
    {
        return new SuccessResponse(
            response: new TariffResource(
                resource: $this->tariffService->update($tariff, $request->toDto())
            ),
            message: 'Тариф обновлен'
        );
    }

    /**
     * Удаление тарифа
     *
     * @urlParam id integer required ID тарифа. Example: 1
     * @responseFile storage/responses/tariff/destroy.json
     * @param Tariff $tariff
     * @return SuccessEmptyResponse
     */
    public function destroy(Tariff $tariff): SuccessEmptyResponse
    {
        $this->tariffService->delete($tariff);

        return new SuccessEmptyResponse(
            message: 'Тариф удален'
        );
    }
}
