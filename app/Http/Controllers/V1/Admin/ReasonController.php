<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\SuccessResponse;
use App\Tbuy\Brand\Repositories\Reason\ReasonRepository;
use App\Tbuy\Reason\Resources\ReasonResource;

/**
 * @group Админ
 * @subgroup Причины
 * @authenticated
 */
class ReasonController extends Controller
{
    public function __construct(
        private readonly ReasonRepository $reasonRepository,
    )
    {
    }

    /**
     * Список причин
     *
     * @responseFile status=200 storage/responses/reason/index.json
     *
     * @return SuccessResponse
     */
    public function index(): SuccessResponse
    {
        $reasons = $this->reasonRepository->get();

        return new SuccessResponse(
            response: ReasonResource::collection($reasons),
            message: 'Reason list',
        );
    }
}
