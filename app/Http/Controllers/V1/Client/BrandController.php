<?php

namespace App\Http\Controllers\V1\Client;

use App\Http\Controllers\Controller;
use App\Http\Responses\SuccessEmptyResponse;
use App\Tbuy\Brand\Models\Brand;
use App\Tbuy\Brand\Services\BrandService;

/**
 * @group Клиент
 * @subgroup Бренд
 * @authenticated
 */
class BrandController extends Controller
{
    public function __construct(private readonly BrandService $brandService)
    {
    }

    /**
     * Подписка на бренд
     *
     * @urlParam company integer required ID бренда. Example: 1
     * @responseFile status=200 storage/responses/brand/subscribe.json
     * @param Brand $brand
     * @return SuccessEmptyResponse
     */
    public function subscribe(Brand $brand): SuccessEmptyResponse
    {
        $this->brandService->subscribe($brand);

        return new SuccessEmptyResponse(
            message: 'Вы успешно подписались'
        );
    }

    /**
     * Отписка от бренд
     *
     * @urlParam company integer required ID бренда. Example: 1
     * @responseFile status=200 storage/responses/brand/unsubscribe.json
     * @param Brand $brand
     * @return SuccessEmptyResponse
     */
    public function unsubscribe(Brand $brand): SuccessEmptyResponse
    {
        $this->brandService->unsubscribe($brand);

        return new SuccessEmptyResponse(
            message: 'Вы успешно отписались'
        );
    }
}
