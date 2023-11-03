<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\SuccessEmptyResponse;
use App\Tbuy\MenuUserPermission\Requests\StoreRequest;
use App\Tbuy\MenuUserPermission\Services\MenuUserService;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Админ
 * @subgroup Меню
 * @authenticated
 */
class MenuUserPermissionController extends Controller
{
    public function __construct(private readonly MenuUserService $userService)
    {
    }

    /**
     * Прикрепление пользователя
     *
     * @bodyParam user_id integer required ID пользователя. Example: 1
     * @bodyParam menu object required
     * @bodyParam menu.0 integer required ID меню. Example: 1
     * @response status=201 {"success": true, "message": "Menu set"}
     * @responseFile status=422 scenario="Validation failed" storage/responses/menu/user/validation-failed.json
     * @param StoreRequest $request
     * @return SuccessEmptyResponse
     */
    public function store(StoreRequest $request): SuccessEmptyResponse
    {
        $this->userService->create($request->toDto());

        return new SuccessEmptyResponse(
            message: 'Menu set',
            status: Response::HTTP_CREATED
        );
    }
}
