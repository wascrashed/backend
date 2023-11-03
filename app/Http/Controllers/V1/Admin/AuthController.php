<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\ErrorResponse;
use App\Http\Responses\SuccessEmptyResponse;
use App\Http\Responses\SuccessResponse;
use App\Tbuy\User\Requests\LoginRequest;
use App\Tbuy\User\Requests\RegisterRequest;
use App\Tbuy\User\Resources\LoginResource;
use App\Tbuy\User\Resources\UserResource;
use App\Tbuy\User\Services\Auth\AuthService;
use Illuminate\Http\Request;

/**
 * @group Админ
 * @subgroup Авторизация
 */
class AuthController extends Controller
{
    public function __construct(private readonly AuthService $authRepository)
    {
    }


    /**
     * Вход
     *
     * @bodyParam email string required Email. Example: email@example.com
     * @bodyParam password string required Пароль.
     * @responseFile storage/responses/auth/login.json
     * @responseFile status=401 scenario="Login failed" storage/responses/auth/login-failed.json
     * @responseFile status=422 scenario="Validation failed" storage/responses/auth/validation-failed.json
     * @param LoginRequest $request
     * @return SuccessResponse|ErrorResponse
     */
    public function login(LoginRequest $request): SuccessResponse|ErrorResponse
    {
        if ($user = $this->authRepository->login($request->all())) {

            return new SuccessResponse(
                response: LoginResource::make([
                    'user' => $user,
                    'access_token' => $user->createToken('authToken')->plainTextToken
                ]),
                message: 'Login success'
            );
        }

        return new ErrorResponse(
            message: 'Login failed',
            status: 401
        );
    }

    public function register(RegisterRequest $request): SuccessResponse
    {
        $user = $this->authRepository->create($request->all());

        return new SuccessResponse(
            response: UserResource::make($user),
            message: 'Register success'
        );
    }

    /**
     * Выход
     *
     * @responseFile storage/responses/auth/logout.json
     * @authenticated
     * @param Request $request
     * @return SuccessEmptyResponse
     */
    public function logout(Request $request): SuccessEmptyResponse
    {
        $request->user()->tokens()->delete();

        return new SuccessEmptyResponse(
            message: 'Logout success'
        );
    }

    /**
     * Авторизованный пользователь
     *
     *
     * @responseFile storage/responses/auth/user.json
     * @authenticated
     * @return SuccessResponse
     */
    public function getAuthUser(): SuccessResponse
    {
        $user = $this->authRepository->getAuthUser();

        return new SuccessResponse(
            response: UserResource::make($user),
            message: 'Информация об авторизованном пользователе'
        );
    }
}
