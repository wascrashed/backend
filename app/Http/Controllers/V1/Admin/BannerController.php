<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\SuccessEmptyResponse;
use App\Http\Responses\SuccessResponse;
use App\Tbuy\Banner\Models\Banner;
use App\Tbuy\Banner\Requests\StoreRequest;
use App\Tbuy\Banner\Requests\UpdateRequest;
use App\Tbuy\Banner\Resources\BannerResource;
use App\Tbuy\Banner\Services\BannerService;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Админ
 * @subgroup Баннер
 * @authenticated
 */
class BannerController extends Controller
{
    public function __construct(
        private readonly BannerService $bannerService
    )
    {
    }

    /**
     * Список
     *
     * @responseFile storage/responses/banner/index.json
     */
    public function index(): SuccessResponse
    {
        $banners = $this->bannerService->getWithCache();

        return new SuccessResponse(
            response: BannerResource::collection($banners),
            message: 'Banner list'
        );
    }

    /**
     * Новый баннер
     *
     * @bodyParam name object required
     * @bodyParam name.ru string required Название баннера на русском. Example: баннер
     * @bodyParam name.en string required Название баннера на английском. Example: banner
     * @bodyParam name.hy string required Название баннера на армянском. Example: banner-hy
     * @bodyParam content object required Контент
     * @responseFile status=201 storage/responses/banner/create.json
     * @responseFile status=422 scenario="Validation failed" storage/responses/banner/validation-failed.json
     */
    public function store(StoreRequest $request): SuccessResponse
    {
        $banner = $this->bannerService->createAndClearCache($request->toDto());

        return new SuccessResponse(
            response: BannerResource::make($banner),
            status: Response::HTTP_CREATED,
            message: 'Banner created'
        );
    }

    /**
     * Просмотр
     *
     * @urlParam banner_id int required ID баннера. Example: 1
     * @responseFile storage/responses/banner/show.json
     */
    public function show(Banner $banner): SuccessResponse
    {
        return new SuccessResponse(
            response: BannerResource::make($banner),
            message: 'Banner detail'
        );
    }

    /**
     * Изменить
     *
     * @urlParam banner_id int required ID баннера. Example: 1
     * @bodyParam name object required
     * @bodyParam name.ru string required Название баннера на русском. Example: баннер
     * @bodyParam name.en string required Название баннера на английском. Example: banner
     * @bodyParam name.hy string required Название баннера на армянском. Example: banner-hy
     * @bodyParam content object required Контент
     * @responseFile status=201 storage/responses/banner/update.json
     * @responseFile status=422 scenario="Validation failed" storage/responses/banner/validation-failed.json
     */
    public function update(UpdateRequest $request, Banner $banner): SuccessResponse
    {
        $banner = $this->bannerService->updateAndClearCache($banner, $request->toDto());

        return new SuccessResponse(
            response: BannerResource::make($banner),
            message: 'Banner updated'
        );
    }

    /**
     * Удалить
     *
     * @urlParam banner_id int required ID баннера. Example: 1
     * @response {"success": true, "message": "Banner deleted"}
     */
    public function destroy(Banner $banner): SuccessEmptyResponse
    {
        $this->bannerService->deleteAndClearCache($banner);

        return new SuccessEmptyResponse(
            message: "banner deleted"
        );
    }
}
