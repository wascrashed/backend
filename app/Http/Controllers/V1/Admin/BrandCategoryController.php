<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\SuccessResponse;
use App\Tbuy\Brand\Models\Brand;
use App\Tbuy\Brand\Requests\BrandSetCategoryRequest;
use App\Tbuy\Brand\Resources\BrandResource;
use App\Tbuy\Brand\Services\BrandService;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Админ
 * @subgroup Бренд
 * @authenticated
 */
class BrandCategoryController extends Controller
{
    public function __construct(private readonly BrandService $brandService)
    {
    }

    /**
     * Прикрепить категорию
     *
     * @urlParam brand_id int required ID бренда. Example: 1
     * @bodyParam category int[] required Список категорий
     * @bodyParam category.0 int required ID категории. Example: 1
     * @responseFile status=201 storage/responses/brand/set-category.json
     * @responseFile status=422 scenario="Validation failed" storage/responses/brand/category-validation-failed.json
     * @param BrandSetCategoryRequest $request
     * @param Brand $brand
     * @return SuccessResponse
     */
    public function store(BrandSetCategoryRequest $request, Brand $brand): SuccessResponse
    {
        $brand = $this->brandService->setCategory($brand, $request->toDto());

        return new SuccessResponse(
            response: BrandResource::make($brand),
            status: Response::HTTP_CREATED,
            message: 'Brand category set'
        );
    }
}
