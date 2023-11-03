<?php

namespace App\Http\Controllers\V1\Client;

use App\Http\Controllers\Controller;
use App\Http\Responses\ErrorResponse;
use App\Http\Responses\SuccessEmptyResponse;
use App\Http\Responses\SuccessResponse;
use App\Tbuy\Employee\Models\CompanyEmployee;
use App\Tbuy\Employee\Requests\EmployeeFilterRequest;
use App\Tbuy\Employee\Requests\EmployeeLoginRequest;
use App\Tbuy\Employee\Requests\EmployeeRequest;
use App\Tbuy\Employee\Resources\EmployeeResource;
use App\Tbuy\Employee\Services\EmployeeService;
use App\Tbuy\User\Resources\LoginResource;
use App\Tbuy\User\Resources\UserResource;

/**
 * @group Клиент
 * @subgroup Сотрудники Компании
 * @authenticated
 */
class EmployeeController extends Controller
{
    public function __construct(
        protected readonly EmployeeService $employeeService
    )
    {
    }

    /**
     * Список сотрудников компании
     *
     * @queryParam  company integer required ID компании. Example: 1
     * @queryParam username string optional Фильтрация по Username. Example: admin
     * @queryParam email string optional Фильтрация по Email. Example: admin@email.com
     * @responseFile storage/responses/company/employee/index.json
     * @param EmployeeFilterRequest $request
     * @return SuccessResponse
     */
    public function index(EmployeeFilterRequest $request): SuccessResponse
    {
        $employees = $this->employeeService->list($request->toDto());

        return new SuccessResponse(
            response: EmployeeResource::collection($employees),
            message: 'Список сотрудников компании'
        );
    }

    /**
     * Информация о сотруднике
     *
     * @urlParam  employee integer required ID сотрудника. Example: 1
     * @responseFile storage/responses/company/employee/show.json
     * @param CompanyEmployee $employee
     * @return SuccessResponse
     */
    public function show(CompanyEmployee $employee): SuccessResponse
    {
        $employee = $this->employeeService->loadRelations($employee);

        return new SuccessResponse(
            response: EmployeeResource::make($employee),
            message: 'Детальная информация о сотруднике'
        );
    }

    /**
     * Добавление сотрудника в компанию
     *
     * @bodyParam company_id int required ID компании в которую добавляется сотрудник. Example: 1
     * @bodyParam email string required Email сотрудника. Example: sotrudnik@email.com
     * @bodyParam username required Никнейм для сотрудника. Example: sotrudnik
     * @responseFile storage/responses/company/employee/store.json
     * @param EmployeeRequest $request
     * @return SuccessResponse
     */
    public function store(EmployeeRequest $request): SuccessResponse
    {
        $employee = $this->employeeService->create($request->toDto());

        return new SuccessResponse(
            response: EmployeeResource::make($employee),
            message: 'Сотрудник успешно зарегистрирован и пароль отправлен на его почту'
        );
    }

    /**
     * Обновление данных сотрудника компании
     *
     * @urlParam  employee integer required ID сотрудника. Example: 1
     * @bodyParam company_id int required ID компании в которую добавляется сотрудник. Example: 1
     * @bodyParam email string required Email сотрудника. Example: sotrudnik@email.com
     * @bodyParam username required Никнейм для сотрудника. Example: sotrudnik
     * @responseFile storage/responses/company/employee/update.json
     * @param EmployeeRequest $request
     * @param CompanyEmployee $employee
     * @return SuccessResponse
     */
    public function update(EmployeeRequest $request, CompanyEmployee $employee): SuccessResponse
    {
        $employee = $this->employeeService->update($employee, $request->toDto());

        return new SuccessResponse(
            response: EmployeeResource::make($employee),
            message: 'Сотрудник успешно обновлен'
        );
    }

    /**
     * Удаление сотрудника компании
     *
     * @urlParam  employee integer required ID сотрудника. Example: 1
     * @responseFile storage/responses/company/employee/destroy.json
     * @param CompanyEmployee $employee
     * @return SuccessEmptyResponse
     */
    public function delete(CompanyEmployee $employee): SuccessEmptyResponse
    {
        $this->employeeService->delete($employee);

        return new SuccessEmptyResponse(
            message: 'Сотрудник успешно удален'
        );
    }

    /**
     * Вход для сотрудников компании
     *
     * @bodyParam company_id int required ID компании. Example: 1
     * @bodyParam email string required Email. Example: email@example.com
     * @bodyParam password string required Пароль.
     * @responseFile status=200 storage/responses/company/employee/login.json
     * @responseFile status=401 storage/responses/company/employee/login-failed.json
     * @param EmployeeLoginRequest $request
     * @return ErrorResponse|SuccessResponse
     */
    public function login(EmployeeLoginRequest $request): ErrorResponse|SuccessResponse
    {
        if ($employee = $this->employeeService->login($request->toDto())) {
            $employee->user->tokens()->where('name', 'EmployeeAuthToken')->delete();

            return new SuccessResponse(
                response: LoginResource::make([
                    'user' => UserResource::make($employee->user),
                    'access_token' => $employee->user->createToken('EmployeeAuthToken')->plainTextToken
                ]),
                message: 'Login success'
            );
        }

        return new ErrorResponse(
            message: 'Login failed',
            status: 401
        );
    }
}
