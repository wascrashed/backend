<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\SuccessEmptyResponse;
use App\Tbuy\Invite\Exceptions\InviteExpiredException;
use App\Tbuy\Invite\Requests\ActivateRequest;
use App\Tbuy\Invite\Requests\StoreRequest;
use App\Tbuy\Invite\Services\InviteService;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Админ
 * @subgroup Приглашения
 * @authenticated
 */
class InviteController extends Controller
{
    public function __construct(private readonly InviteService $inviteService)
    {
    }

    /**
     * Новый токен
     *
     * @bodyParam company_id int required ID компании. Example: 1
     * @bodyParam email string required Электронная почта. Example: admin@admin.com
     * @bodyParam username string required Имя пользователя. Example: some-username
     * @bodyParam expired_at string required Дата истечения токена.<br/>
     * Формат: <b>YYYY-MM-DD</b>.<br/>
     * Example: 2024-01-14
     * @response status=201 {"success": true, "message": "Token created"}
     * @param StoreRequest $request
     * @return SuccessEmptyResponse
     */
    public function store(StoreRequest $request): SuccessEmptyResponse
    {
        $this->inviteService->createAndSendNotification($request->toDto());

        return new SuccessEmptyResponse(
            message: "Token created",
            status: Response::HTTP_CREATED
        );
    }

    /**
     * Активация приглашения
     *
     * @bodyParam token string required Token. Example: some-token
     * @response {"success": true, "message": "Token activated"}
     * @response scenario="Дата токена истекла" {"success": true, "message": "Приглашение просрочено"}
     * @param ActivateRequest $request
     * @return SuccessEmptyResponse
     */
    public function activate(ActivateRequest $request): SuccessEmptyResponse
    {
        try {
            $this->inviteService->activateByToken($request->get('token'));
        } catch (InviteExpiredException $exception) {
            return new SuccessEmptyResponse(
                message: $exception->getMessage()
            );
        }

        return new SuccessEmptyResponse(
            message: "Token activated"
        );
    }
}
