<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\SuccessEmptyResponse;
use App\Http\Responses\SuccessResponse;
use App\Tbuy\Category\Models\Category;
use App\Tbuy\Category\Requests\StoreRequest;
use App\Tbuy\Category\Requests\UpdateRequest;
use App\Tbuy\Category\Resources\CategoryResource;
use App\Tbuy\Category\Services\CategoryService;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
/**
 * @group Админ
 * @subgroup Категории
 * @authenticated
 */
class CategoryController extends Controller
{
    public function __construct(private readonly CategoryService $categoryService)
    {
    }

    /**
     * Получение списка категорий
     *
     * @responseFile storage/responses/category/index.json
     * @return SuccessResponse
     */
    public function index(): SuccessResponse
    {
        $category = $this->categoryService->get();

        return new SuccessResponse(
            response: CategoryResource::collection($category),
            message: "Category list"
        );
    }

    /**
     * Получение уровня категории
     *
     * @urlParam category_id int required ID категории. Example: 155
     * @response {"success": true, "message": "Category level", "data":{"ratio": 3}}
     * @param Category $category
     * @return SuccessResponse
     */
    public function getChildLevel(Category $category): SuccessResponse
    {
        $ratio = $this->categoryService->getChildLevel($category);

        return new SuccessResponse(
            response: response([
                'ratio' => $ratio
            ]),
            message: 'Category level'
        );
    }

    /**
     * Создание категории
     *
     * @bodyParam name string required Название категории. Example: Phone
     * @bodyParam slug string required Название категории. Example: phone
     * @bodyParam parent_id integer ID Название категории. Example: 1
     * @responseFile status=201 storage/responses/category/store.json
     * @responseFile status=422 scenario="Validation failed" storage/responses/category/validation-failed.json
     * @param StoreRequest $request
     * @return SuccessResponse
     */
    public function store(StoreRequest $request): SuccessResponse
    {
        $createCategory = $this->categoryService->store($request->toDto());

        return new SuccessResponse(
            response: CategoryResource::make($createCategory),
            status: Response::HTTP_CREATED,
            message: "Category created"
        );
    }

    /**
     * Детали информация категории
     *
     * @urlParam category integer required ID категории. Example: 1
     * @responseFile storage/responses/category/show.json
     * @param Category $category
     * @return SuccessResponse
     */
    public function show(Category $category): SuccessResponse
    {
        return new SuccessResponse(
            response: CategoryResource::make($category),
            message: "Category detail"
        );
    }

    /**
     * Обновление данных категории
     *
     * @urlParam category integer required ID категории. Example: 1
     * @bodyParam name string required Название категории. Example: Phone
     * @bodyParam slug string required Название категории. Example: phone
     * @bodyParam parent_id integer ID Название категории. Example: 1
     * @responseFile status=201 storage/responses/category/update.json
     * @responseFile status=422 scenario="Validation failed" storage/responses/category/validation-failed.json
     * @param UpdateRequest $request
     * @param Category $category
     * @return SuccessResponse
     */
    public function update(UpdateRequest $request, Category $category): SuccessResponse
    {
        $updateCategory = $this->categoryService->update($category, $request->toDto());

        return new SuccessResponse(
            response: CategoryResource::make($updateCategory),
            message: "Category update"
        );
    }

    /**
     * Удаление категории
     *
     * @urlParam category integer required ID категории. Example: 1
     * @responseFile status=201 storage/responses/category/destroy.json
     * @param Category $category
     * @return SuccessEmptyResponse
     */
    public function destroy(Category $category): SuccessEmptyResponse
    {
        $this->categoryService->delete($category);

        return new SuccessEmptyResponse(
            message: "Category deleted"
        );
    }

}
