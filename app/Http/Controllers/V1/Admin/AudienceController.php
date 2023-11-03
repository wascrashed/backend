<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\SuccessEmptyResponse;
use App\Http\Responses\SuccessResponse;
use App\Tbuy\Audience\Models\Audience;
use App\Tbuy\Audience\Requests\StoreRequest;
use App\Tbuy\Audience\Requests\UpdateRequest;
use App\Tbuy\Audience\Resources\AudienceResource;
use App\Tbuy\Audience\Services\AudienceService;

/**
 * @group Админ
 * @subgroup Аудитория
 */
class AudienceController extends Controller
{
    public function __construct(
        public readonly AudienceService $audienceService
    )
    {
    }

    /**
     * Получение списка аудиторий
     *
     * @responseFile storage/responses/audience/index.json
     * @return SuccessResponse
     */
    public function index(): SuccessResponse
    {
        return new SuccessResponse(
            response: AudienceResource::collection($this->audienceService->get()),
            message: 'Список аудиторий'
        );
    }

    /**
     * Создание аудитории
     *
     * @bodyParam name array required Массив названий аудитории.
     * @bodyParam name.ru string Название аудитории на языке. Example: Название
     * @bodyParam name.en string Название аудитории на языке. Example: Название
     * @bodyParam name.hy string Название аудитории на языке. Example: Название
     * @bodyParam company_id integer ID required компании. Example: 1
     * @bodyParam country_id integer ID required страны. Example: 1
     * @bodyParam region_id integer ID required региона. Example: 1
     * @bodyParam gender string required Пол аудитории <br/>
     * <b>m</b> - мужчина <br/>
     * <b>f</b> - женщина <br/>
     * <b>all</b> - все <br/>
     * Example: all
     * @bodyParam age array required Массив возрастов.
     * @bodyParam age.min integer required Минимальный возраст. Example: 1
     * @bodyParam age.max integer required Максимальный возраст. Example: 100
     * @responseFile status=201 storage/responses/audience/store.json
     * @responseFile status=422 scenario="Validation failed" storage/responses/audience/validation-failed.json
     * @param StoreRequest $request
     * @return SuccessResponse
     */
    public function store(StoreRequest $request): SuccessResponse
    {
        return new SuccessResponse(
            response: new AudienceResource($this->audienceService->create($request->toDto())),
            message: 'Аудитория создана'
        );
    }

    /**
     * Получение деталей аудитории
     *
     * @urlParam id integer required ID аудитории. Example: 1
     * @responseFile storage/responses/audience/show.json
     * @param Audience $audience
     * @return SuccessResponse
     */
    public function show(Audience $audience): SuccessResponse
    {
        return new SuccessResponse(
            response: new AudienceResource($this->audienceService->show($audience)),
            message: 'Детали аудитории'
        );
    }

    /**
     * Обновление аудитории
     *
     * @urlParam id integer required ID аудитории. Example: 1
     * @bodyParam name array Массив названий аудитории.
     * @bodyParam name.ru string Название аудитории на языке. Example: Название
     * @bodyParam name.en string Название аудитории на языке. Example: Название
     * @bodyParam name.hy string Название аудитории на языке. Example: Название
     * @bodyParam company_id integer ID required компании. Example: 1
     * @bodyParam country_id integer ID required страны. Example: 1
     * @bodyParam region_id integer ID required региона. Example: 1
     * @bodyParam gender string required Пол аудитории <br/>
     * <b>m</b> - мужчина <br/>
     * <b>f</b> - женщина <br/>
     * <b>all</b> - все <br/>
     * Example: all
     * @bodyParam age array Массив возрастов.
     * @bodyParam age.min integer required Минимальный возраст. Example: 1
     * @bodyParam age.max integer required Максимальный возраст. Example: 100
     * @responseFile status=201 storage/responses/audience/update.json
     * @responseFile status=422 scenario="Validation failed" storage/responses/audience/validation-failed.json
     * @param UpdateRequest $request
     * @param Audience $audience
     * @return SuccessResponse
     */
    public function update(UpdateRequest $request, Audience $audience): SuccessResponse
    {
        return new SuccessResponse(
            response: new AudienceResource($this->audienceService->update($request->toDto(), $audience)),
            message: 'Аудитория обновлена'
        );
    }

    /**
     * Удаление аудитории
     *
     * @urlParam id integer required ID аудитории. Example: 1
     * @responseFile storage/responses/audience/destroy.json
     * @param Audience $audience
     * @return SuccessEmptyResponse
     */
    public function destroy(Audience $audience): SuccessEmptyResponse
    {
        $this->audienceService->delete($audience);

        return new SuccessEmptyResponse(
            message: 'Аудитория удалена'
        );
    }
}
