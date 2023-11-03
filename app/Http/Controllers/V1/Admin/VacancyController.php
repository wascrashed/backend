<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\SuccessEmptyResponse;
use App\Http\Responses\SuccessResponse;
use App\Tbuy\Vacancy\Models\Vacancy;
use App\Tbuy\Vacancy\Requests\StoreRequest;
use App\Tbuy\Vacancy\Requests\UpdateRequest;
use App\Tbuy\Vacancy\Resources\VacancyResource;
use App\Tbuy\Vacancy\Services\VacancyService;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Админ
 * @subgroup Вакансии
 * @authenticated
 */
class VacancyController extends Controller
{
    public function __construct(
        private readonly VacancyService $vacancyService
    )
    {
    }

    /**
     * Получение всех вакансий
     *
     * @responseFile storage/responses/vacancy/index.json
     * @return SuccessResponse
     */
    public function index(): SuccessResponse
    {
        return new SuccessResponse(
            response: VacancyResource::collection($this->vacancyService->get()),
            message: 'Список вакансий'
        );
    }

    /**
     * Создание вакансии
     *
     * @bodyParam category_id integer ID required Идентификатор категории вакансии. Example: 5
     * @bodyParam title array  required Массив заголовков.
     * @bodyParam title.ru string required Заголовок на каком-либо языка. Example: Разнорабочий
     * @bodyParam title.en string required Заголовок на каком-либо языка. Example: Разнорабочий
     * @bodyParam title.hy string required Заголовок на каком-либо языка. Example: Разнорабочий
     * @bodyParam description array  required Массив описаний.
     * @bodyParam description.ru string required Описание на каком-либо языка. Example: Разнорабочий на склад
     * @bodyParam description.en string required Описание на каком-либо языка. Example: Разнорабочий на склад
     * @bodyParam description.hy string required Описание на каком-либо языка. Example: Разнорабочий на склад
     * @bodyParam salary integer required Оплата вакансии. Example: 1000
     * @bodyParam tags array Массив тегов.
     * @bodyParam tags.* string required Тег. Example: работа
     * @bodyParam images array Массив изображений.
     * @bodyParam images.* file required Изображение (jpg,jpeg,png)
     * @responseFile status=201 storage/responses/vacancy/store.json
     * @param StoreRequest $request
     * @return SuccessResponse
     */
    public function store(StoreRequest $request): SuccessResponse
    {
        $vacancy = $this->vacancyService->create($request->toDto());

        return new SuccessResponse(
            response: new VacancyResource($vacancy),
            status: Response::HTTP_CREATED,
            message: 'Вакансия успешно создана'
        );
    }

    /**
     * Получение определенной вакансии
     *
     * @urlParam integer ID required Идентификатор вакансии. Example: 1
     * @responseFile storage/responses/vacancy/show.json
     * @param Vacancy $vacancy
     * @return SuccessResponse
     */
    public function show(Vacancy $vacancy): SuccessResponse
    {
        return new SuccessResponse(
            response: new VacancyResource($vacancy->load(['category', 'tags', 'images'])),
            message: 'Детали вакансии'
        );
    }

    /**
     * Обновление вакансии
     *
     * @urlParam integer ID required Идентификатор вакансии. Example: 1
     * @bodyParam category_id integer ID Идентификатор категории вакансии. Example: 5
     * @bodyParam title array Массив заголовков.
     * @bodyParam title.ru string required Заголовок на каком-либо языка. Example: Разнорабочий
     * @bodyParam title.en string required Заголовок на каком-либо языка. Example: Разнорабочий
     * @bodyParam title.hy string required Заголовок на каком-либо языка. Example: Разнорабочий
     * @bodyParam description array Массив описаний.
     * @bodyParam description.ru string required Описание на каком-либо языка. Example: Разнорабочий на склад
     * @bodyParam description.en string required Описание на каком-либо языка. Example: Разнорабочий на склад
     * @bodyParam description.hy string required Описание на каком-либо языка. Example: Разнорабочий на склад
     * @bodyParam salary integer Оплата вакансии. Example: 1000
     * @bodyParam tags array Массив тегов.
     * @bodyParam tags.* string required Тег. Example: работа
     * @bodyParam images array Массив изображений.
     * @bodyParam images.* file required Изображение (jpg,jpeg,png)
     * @responseFile status=200 storage/responses/vacancy/update.json
     * @param UpdateRequest $request
     * @param Vacancy $vacancy
     * @return SuccessResponse
     */
    public function update(UpdateRequest $request, Vacancy $vacancy): SuccessResponse
    {
        $vacancy = $this->vacancyService->update($request->toDto(), $vacancy);

        return new SuccessResponse(
            response: new VacancyResource($vacancy),
            message: 'Вакансия успешно обновлена'
        );
    }

    /**
     * Удаление вакансии
     *
     * @urlParam integer ID required Идентификатор вакансии. Example: 1
     * @responseFile status=200 storage/responses/vacancy/destroy.json
     * @param Vacancy $vacancy
     * @return SuccessEmptyResponse
     */
    public function destroy(Vacancy $vacancy): SuccessEmptyResponse
    {
        $this->vacancyService->delete($vacancy);

        return new SuccessEmptyResponse(
            message: 'Вакансия успешно удалена'
        );
    }
}
