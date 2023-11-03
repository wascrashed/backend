<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\SuccessEmptyResponse;
use App\Http\Responses\SuccessResponse;
use App\Tbuy\Target\Models\Target;
use App\Tbuy\Target\Requests\ChangeStatusRequest;
use App\Tbuy\Target\Requests\StoreRequest;
use App\Tbuy\Target\Requests\UpdateRequest;
use App\Tbuy\Target\Resources\TargetResource;
use App\Tbuy\Target\Services\TargetService;

/**
 * @group Админ
 * @subgroup Таргет
 */
class TargetController extends Controller
{
    public function __construct(
        public readonly TargetService $targetService
    )
    {
    }

    /**
     * Получение списка рассылок
     *
     * @responseFile storage/responses/target/index.json
     * @return SuccessResponse
     */
    public function index(): SuccessResponse
    {
        return new SuccessResponse(
            response: TargetResource::collection($this->targetService->get()),
            message: 'Список рассылок'
        );
    }

    /**
     * Создание рассылки
     *
     * @bodyParam audience_id required int ID аудитории. Example: 1
     * @bodyParam targetable_type required string Тип объекта для рассылки. Example: product
     * @bodyParam targetable_id required int ID типа объекта для рассылки. Example: 1
     * @bodyParam name required array Массив название.
     * @bodyParam name.ru required string Название на языке. Example: Test
     * @bodyParam name.en required string Название на языке. Example: Test
     * @bodyParam name.hy required string Название на языке. Example: Test
     * @bodyParam link required string Ссылка. Example: http://localhost/
     * @bodyParam duration required int Время продолжительности. Example: -5
     * @bodyParam started_at required string Дата начала. Example: 2023-07-27 14:13:53
     * @bodyParam finished_at required string Дата завершения. Example: 2023-07-27 14:13:53
     * @responseFile status=201 storage/responses/target/store.json
     * @responseFile status=422 scenario="Validation failed" storage/responses/target/validation-failed.json
     * @param StoreRequest $request
     * @return SuccessResponse
     */
    public function store(StoreRequest $request): SuccessResponse
    {
        return new SuccessResponse(
            response: new TargetResource($this->targetService->create($request->toDto())),
            message: 'Рассылка создана'
        );
    }

    /**
     * Получение деталей рассылки
     *
     * @urlParam id integer required ID рассылки. Example: 1
     * @responseFile storage/responses/target/show.json
     * @param Target $target
     * @return SuccessResponse
     */
    public function show(Target $target): SuccessResponse
    {
        return new SuccessResponse(
            response: new TargetResource($this->targetService->show($target)),
            message: 'Детали рассылки'
        );
    }

    /**
     * Обновление рассылки
     *
     * @urlParam id integer required ID рассылки. Example: 1
     * @bodyParam audience_id required int ID аудитории. Example: 1
     * @bodyParam targetable_type required string Тип объекта для рассылки. Example: product
     * @bodyParam targetable_id required int ID типа объекта для рассылки. Example: 1
     * @bodyParam name array Массив название.
     * @bodyParam name.ru required string Название на языке. Example: Test
     * @bodyParam name.en required string Название на языке. Example: Test
     * @bodyParam name.hy required string Название на языке. Example: Test
     * @bodyParam link required string Ссылка. Example: http://localhost/
     * @bodyParam duration required int Время продолжительности. Example: -5
     * @bodyParam started_at required string Дата начала. Example: 2023-07-27 14:13:53
     * @bodyParam finished_at required string Дата завершения. Example: 2023-07-27 14:13:53
     * @responseFile status=200 storage/responses/target/update.json
     * @responseFile status=422 scenario="Validation failed" storage/responses/target/validation-failed.json
     * @param UpdateRequest $request
     * @param Target $target
     * @return SuccessResponse
     */
    public function update(UpdateRequest $request, Target $target): SuccessResponse
    {
        return new SuccessResponse(
            response: new TargetResource($this->targetService->update($request->toDto(), $target)),
            message: 'Рассылка обновлена'
        );
    }

    /**
     * Удаление рассылки
     *
     * @urlParam id integer required ID рассылки. Example: 1
     * @responseFile storage/responses/target/destroy.json
     * @param Target $target
     * @return SuccessEmptyResponse
     */
    public function destroy(Target $target): SuccessEmptyResponse
    {
        $this->targetService->delete($target);

        return new SuccessEmptyResponse(
            message: 'Рассылка удалена'
        );
    }

    /**
     * Изменение статуса рассылки
     *
     * @urlParam id integer required ID рассылки. Example: 1
     * @bodyParam status required string Статус рассылки. <br/>
     * <b>new</b> - Новый <br/>
     * <b>accepted</b> - Подтвержден <br/>
     * <b>rejected</b> - Отклонен <br/>
     * <b>in-progress</b> - В процессе <br/>
     * <b>archived</b> - В архиве <br/>
     * Example: new
     * @responseFile status=200 storage/responses/target/change-status.json
     * @responseFile status=422 scenario="Validation failed" storage/responses/target/change-status-failed.json
     * @param ChangeStatusRequest $request
     * @param Target $target
     * @return SuccessResponse
     */
    public function changeStatus(ChangeStatusRequest $request, Target $target): SuccessResponse
    {
        return new SuccessResponse(
            response: new TargetResource($this->targetService->changeStatus($request->toDto(), $target)),
            message: 'Статус изменен'
        );
    }

    /**
     * Инкрементация просмотров рассылки
     *
     * @urlParam id integer required ID рассылки. Example: 1
     * @responseFile storage/responses/target/increment-views.json
     * @responseFile storage/responses/target/increment-views.json
     * @param Target $target
     * @return SuccessEmptyResponse
     */
    public function incrementViews(Target $target): SuccessEmptyResponse
    {
        $this->targetService->incrementViews($target);

        return new SuccessEmptyResponse(
            message: 'Просмотр добавлен'
        );
    }
}
