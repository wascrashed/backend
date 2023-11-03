<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\SuccessEmptyResponse;
use App\Http\Responses\SuccessResponse;
use App\Tbuy\User\Requests\StoreRequest;
use App\Tbuy\User\Models\User;
use App\Tbuy\User\Requests\UpdateRequest;
use App\Tbuy\User\Resources\UserResource;
use App\Tbuy\User\Services\UserService;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * @group Админ
 * @subgroup Пользователи
 */
class UserController extends Controller
{
    /**
     * UserController constructor.
     *
     * @param UserService $userService
     */
    public function __construct(
        private readonly UserService $userService
    )
    {
    }

    /**
     * Получить список пользователей
     *
     * @return SuccessResponse
     */
    public function index(): SuccessResponse
    {
        $users = $this->userService->get();

        return new SuccessResponse(
            response: UserResource::collection($users),
            message: 'Список пользователей'
        );
    }

    /**
     * Создать нового пользователя
     *
     * @param StoreRequest $request
     * @return SuccessResponse
     */
    public function store(StoreRequest $request): SuccessResponse
    {
        $user = $this->userService->store($request->toDto());

        return new SuccessResponse(
            response: UserResource::make($user),
            status: ResponseAlias::HTTP_CREATED,
            message: 'Пользователь успешно создан'
        );
    }

    /**
     * Получить полную информацию о пользователе
     *
     * @param User $user
     * @return SuccessResponse
     */
    public function show(User $user): SuccessResponse
    {
        return new SuccessResponse(
            response: UserResource::make($user),
            message: 'Полная информация о пользователе'
        );
    }

    /**
     * Обновить информацию о пользователе
     *
     * @param UpdateRequest $request
     * @param User $user
     * @return SuccessResponse
     */
    public function update(UpdateRequest $request, User $user): SuccessResponse
    {
        $user = $this->userService->update($user, $request->toDto());

        return new SuccessResponse(
            response: UserResource::make($user),
            message: 'Пользователь успешно обновлен'
        );
    }

    /**
     * Удалить пользователя
     *
     * @param User $user
     * @return SuccessEmptyResponse
     */
    public function destroy(User $user): SuccessEmptyResponse
    {
        $this->userService->delete($user);

        return new SuccessEmptyResponse(
            message: 'Пользователь успешно удален'
        );
    }
}
