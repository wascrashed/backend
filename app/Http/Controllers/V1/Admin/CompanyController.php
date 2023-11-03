<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\SuccessEmptyResponse;
use App\Http\Responses\SuccessResponse;
use App\Tbuy\Company\Models\Company;
use App\Tbuy\Company\Requests\CompanyFilterRequest;
use App\Tbuy\Company\Requests\CompanyToggleStatusRequest;
use App\Tbuy\Company\Requests\StoreRequest;
use App\Tbuy\Company\Requests\UpdateRequest;
use App\Tbuy\Company\Resources\CompanyFullResource;
use App\Tbuy\Company\Resources\CompanyResource;
use App\Tbuy\Company\Resources\EmployeeResource;
use App\Tbuy\Company\Services\CompanyService;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Админ
 * @subgroup Компании
 * @authenticated
 */
class CompanyController extends Controller
{
    public function __construct(private readonly CompanyService $companyService)
    {
    }

    /**
     * Получение списка компаний
     *
     * @queryParam status string Фильтр по статусам.<br/>
     * <b>active</b> - для активных компаний <br/>
     * <b>approved</b> - для одобренных компаний <br/>
     * <b>archived</b> - для архивированных компаний. <br/>
     * <b>moderation</b> - для компании которое в модерации. <br/>
     * <b>new</b> - для новых компаний. <br/>
     * <b>rejected</b> - для отклонённых компаний. <br/>
     * Example: rejected
     * @queryParam parent bool Только гловные компании. Example: 1
     * @responseFile storage/responses/company/index.json
     * @param CompanyFilterRequest $request
     * @return SuccessResponse
     */
    public function index(CompanyFilterRequest $request): SuccessResponse
    {
        $company = $this->companyService->get($request->toDto());

        return new SuccessResponse(
            response: CompanyResource::collection($company),
            message: "Список компаний"
        );
    }

    /**
     * Создание компании
     *
     * @bodyParam name array required Название компании на разных языках.
     * @bodyParam name.ru string required Название компании на русском. Example: ООО "Пример"
     * @bodyParam name.en string required Название компании на английском. Example: Example LLC
     * @bodyParam name.hy string required Название компании на армянском. Example: ՕՕՕ "Օրինակ"
     * @bodyParam type string required Тип компании.<br/>
     * <b>sales</b> - торговля<br/>
     * <b>services</b> - услуги.<br>/
     * Example: sales
     * @bodyParam inn string required ИНН компании. Example: 1234567890
     * @bodyParam director array required Информация о директоре.
     * @bodyParam director.first_name string required Имя директора. Example: Иван
     * @bodyParam director.last_name string required Фамилия директора. Example: Иванов
     * @bodyParam phone string required Телефон компании. Example: +1234567890
     * @bodyParam email string required Email компании. Example: company@example.com
     * @bodyParam slug string required Название читаемой ссылки. Example: example-company
     * @bodyParam legal_entity boolean required Признак юридического лица (true, false). Example: true
     * @bodyParam brand_document file required Документ бренда (изображение или PDF). Максимальный размер: 5MB.
     * @bodyParam inn_document file required Документ ИНН (изображение или PDF). Максимальный размер: 5MB.
     * @bodyParam passport_document file required Документ паспорта (изображение или PDF). Максимальный размер: 5MB.
     * @bodyParam state_register_document file required Документ государственной регистрации (изображение или PDF). Максимальный размер: 5MB.
     * @bodyParam parent_id int  ID родительской компании, если есть. Example: 1
     * @responseFile status=201 storage/responses/company/store.json
     * @responseFile status=422 scenario="Validation failed" storage/responses/company/validation-failed.json
     * @param StoreRequest $request
     * @return SuccessResponse
     */

    public function store(StoreRequest $request): SuccessResponse
    {
        $createCompany = $this->companyService->store($request->toDto());

        return new SuccessResponse(
            response: CompanyResource::make($createCompany),
            status: Response::HTTP_CREATED,
            message: "Компания создана"
        );
    }

    /**
     * Детали информации о компании
     *
     * @urlParam company integer required ID компании. Example: 1
     * @responseFile storage/responses/company/show.json
     * @param Company $company
     * @return SuccessResponse
     */
    public function show(Company $company): SuccessResponse
    {
        return new SuccessResponse(
            response: CompanyFullResource::make($company->load([
                'brandDocument',
                'innDocument',
                'passportDocument',
                'stateRegisterDocument',
                'rejections.reason',
                'rejections.user'
            ])),
            message: "Детали компании"
        );
    }

    /**
     * Обновление данных компании
     *
     * @urlParam company integer required ID компании. Example: 1
     * @bodyParam name array required Название компании на разных языках.
     * @bodyParam name.ru string required Название компании на русском. Example: ООО "Новое название"
     * @bodyParam name.en string required Название компании на английском. Example: New Name LLC
     * @bodyParam name.hy string required Название компании на армянском. Example: Նոր անվանում
     * @bodyParam slug string required Название читаемой ссылки. Example: new-slug
     * @bodyParam type string required Тип компании.<br/>
     * <b>sales</b> - торговля<br/>
     * <b>services</b> - услуги.<br>/
     * Example: sales
     * @bodyParam inn string required ИНН компании. Example: 9876543210
     * @bodyParam director array required Информация о директоре.
     * @bodyParam director.first_name string required Имя директора. Example: Петр
     * @bodyParam director.last_name string required Фамилия директора. Example: Петров
     * @bodyParam phone string required Телефон компании. Example: +9876543210
     * @bodyParam email string required Email компании. Example: new@example.com
     * @bodyParam legal_entity boolean required Признак юридического лица (true, false). Example: false
     * @responseFile status=201 storage/responses/company/update.json
     * @responseFile status=422 scenario="Validation failed" storage/responses/company/validation-failed.json
     * @param UpdateRequest $request
     * @param Company $company
     * @return SuccessResponse
     */

    public function update(UpdateRequest $request, Company $company): SuccessResponse
    {
        $updateCompany = $this->companyService->update($company, $request->toDto());

        return new SuccessResponse(
            response: CompanyResource::make($updateCompany),
            message: "Данные компании обновлены"
        );
    }

    /**
     * Изменение статуса компании
     *
     * @urlParam company_id integer required ID компании. Example: 1
     * @bodyParam status string required <br/>
     * <b>active</b> - активация <br/>
     * <b>approved</b> - подтверждение <br/>
     * <b>archived</b> - архив <br/>
     * <b>moderation</b> - в модерации <br/>
     * <b>new</b> - новый <br/>
     * <b>rejected</b> - отказано <br/>
     * Example: accepted
     * @bodyParam reason_id int ID причины отказа, обязательно когда статус - <b>rejected</b>. Example: 3
     * @responseFile storage/responses/company/update-status.json
     * @responseFile status=422 scenario="Validation failed" storage/responses/company/update-status-failed.json
     * @urlParam company integer required ID компании. Example: 1
     * @responseFile status=204 storage/responses/company/toggle-status.json
     * @param CompanyToggleStatusRequest $request
     * @param Company $company
     * @return SuccessEmptyResponse
     */
    public function toggleStatus(CompanyToggleStatusRequest $request, Company $company): SuccessEmptyResponse
    {
        $this->companyService->toggleStatus($company, $request->toDto());

        return new SuccessEmptyResponse(
            message: "Статус изменен"
        );
    }

    /**
     * Удаление компании
     *
     * @urlParam company integer required ID компании. Example: 1
     * @responseFile status=200 storage/responses/company/destroy.json
     * @param Company $company
     * @return SuccessEmptyResponse
     */
    public function destroy(Company $company): SuccessEmptyResponse
    {
        $this->companyService->delete($company);

        return new SuccessEmptyResponse(
            message: "Компания удалена"
        );
    }

    /**
     * Получение списка сотрудников компании
     *
     * @param Company $company
     * @urlParam company_id int required ID компании. Example: 1
     * @responseFile status=200 storage/responses/company/get-employee.json
     * @responseCollection EmployeeResource
     * @return SuccessResponse
     */
    public function getEmployees(Company $company)
    {
        $employees = $this->companyService->getEmployees($company);
        return new SuccessResponse(

            response: EmployeeResource::collection($employees),
            message: "Список сотрудников компании: "
        );
    }
}

