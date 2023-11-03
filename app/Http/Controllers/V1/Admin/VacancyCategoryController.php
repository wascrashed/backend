<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\SuccessEmptyResponse;
use App\Http\Responses\SuccessResponse;
use App\Tbuy\Vacancy\Models\VacancyCategory;
use App\Tbuy\Vacancy\Requests\VacancyCategory\StoreRequest;
use App\Tbuy\Vacancy\Requests\VacancyCategory\UpdateRequest;
use App\Tbuy\Vacancy\Resources\VacancyCategoryResource;
use App\Tbuy\Vacancy\Services\VacancyCategory\VacancyCategoryService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Админ
 * @subgroup Категории вакансий
 * @authenticated
 */
class VacancyCategoryController extends Controller
{
    public function __construct(
        private readonly VacancyCategoryService $vacancyCategoryService
    )
    {
    }

    /**
     * Получение всех категорий вакансий
     *
     * @responseFile storage/responses/vacancy-category/index.json
     * @return SuccessResponse
     */
    public function index(): SuccessResponse
    {
        return new SuccessResponse(
            response: VacancyCategoryResource::collection($this->vacancyCategoryService->get()),
            message: 'Список категорий вакансий'
        );
    }

    /**
     * Создание категории вакансий
     *
     * @bodyParam name array required Массив названий.
     * @bodyParam name.ru string required Название на каком-либо языке. Example: Подработка
     * @bodyParam name.en string required Название на каком-либо языке. Example: Подработка
     * @bodyParam name.hy string required Название на каком-либо языке. Example: Подработка
     * @responseFile status=201 storage/responses/vacancy-category/store.json
     * @param StoreRequest $request
     * @return SuccessResponse
     */
    public function store(StoreRequest $request): SuccessResponse
    {
        $category = $this->vacancyCategoryService->create($request->toDto());

        return new SuccessResponse(
            response: new VacancyCategoryResource($category),
            status: Response::HTTP_CREATED,
            message: 'Категория вакансий успешно создана'
        );
    }

    /**
     * Получение определенной категории вакансий
     *
     * @urlParam integer ID required Идентификатор категории. Example: 1
     * @responseFile storage/responses/vacancy-category/show.json
     * @param VacancyCategory $category
     * @return SuccessResponse
     */
    public function show(VacancyCategory $category): SuccessResponse
    {
        return new SuccessResponse(
            response: new VacancyCategoryResource($category),
            message: 'Детали категории вакансий'
        );
    }

    /**
     * Обновление категории вакансий
     *
     * @urlParam integer ID required Идентификатор категории. Example: 1
     * @bodyParam name array required Массив названий.
     * @bodyParam name.ru string required Название на каком-либо языке. Example: Подработка
     * @bodyParam name.en string required Название на каком-либо языке. Example: Подработка
     * @bodyParam name.hy string required Название на каком-либо языке. Example: Подработка
     * @responseFile status=200 storage/responses/vacancy-category/update.json
     * @param UpdateRequest $request
     * @param VacancyCategory $category
     * @return SuccessResponse
     */
    public function update(UpdateRequest $request, VacancyCategory $category): SuccessResponse
    {
        $category = $this->vacancyCategoryService->update($request->toDto(), $category);

        return new SuccessResponse(
            response: new VacancyCategoryResource($category),
            message: 'Категория вакансий успешно обновлена'
        );
    }

    /**
     * Удаление категории вакансий
     *
     * @urlParam integer ID required Идентификатор категории. Example: 1
     * @responseFile status=200 storage/responses/vacancy-category/destroy.json
     * @param VacancyCategory $category
     * @return SuccessEmptyResponse
     */
    public function destroy(VacancyCategory $category): SuccessEmptyResponse
    {
        $this->vacancyCategoryService->delete($category);

        return new SuccessEmptyResponse(
            message: 'Категория вакансий успешно удалена'
        );
    }
}
