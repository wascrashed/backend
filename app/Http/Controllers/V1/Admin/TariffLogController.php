<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\TariffLogResource;
use App\Http\Responses\SuccessResponse;
use App\Tbuy\Tariff\Requests\TariffLogFilterRequest;
use App\Tbuy\Tariff\Services\TariffLogService;

/**
 * @group Админ
 * @subgroup Тарифы
 */
class TariffLogController extends Controller
{
    public function __construct(
        private readonly TariffLogService $tariffLogService
    )
    {
    }

    /**
     * Логи
     *
     * @queryParam company_id int ID компании. Example: 1
     * @queryParam tariff_id int ID тарифа. Example: 1
     * @queryParam user_id int ID покупателя. Example: 1
     * @responseFile storage/responses/tariff/index-log.json
     * @param TariffLogFilterRequest $request
     * @return SuccessResponse
     */
    public function index(TariffLogFilterRequest $request): SuccessResponse
    {
        $logs = $this->tariffLogService->getWithCache($request->toDto());

        return new SuccessResponse(
            response: TariffLogResource::collection($logs),
            message: 'Tariff log list'
        );
    }
}
