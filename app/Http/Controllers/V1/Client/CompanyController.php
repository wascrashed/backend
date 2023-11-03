<?php

namespace App\Http\Controllers\V1\Client;

use App\Http\Controllers\Controller;
use App\Http\Responses\SuccessEmptyResponse;
use App\Http\Responses\SuccessResponse;
use App\Tbuy\Company\Models\Company;
use App\Tbuy\Company\Requests\CompanyScoreRequest;
use App\Tbuy\Company\Requests\RegisterRequest;
use App\Tbuy\Company\Requests\DataConfirmationRequest;
use App\Tbuy\Company\Requests\StoreRequest;
use App\Tbuy\Company\Resources\CompanyResource;
use App\Tbuy\Company\Services\CompanyService;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Клиент
 * @subgroup Компании
 * @authenticated
 */
class CompanyController extends Controller
{
    public function __construct(private readonly CompanyService $companyService)
    {
    }

    /**
     * Регистрация компании
     *
     * @bodyParam name string required Название компании
     * @bodyParam type string required Тип компании: sales или services
     * @bodyParam director[first_name] string required Имя директора компании
     * @bodyParam director[last_name] string required Фамилия директора компании
     * @bodyParam phone string required Телефоный номер компании
     * @bodyParam email email required Почта компании
     * @bodyParam inn string required ИНН компании
     * @bodyParam inn_document file required Инн документ компании в виде файла jpg,jpeg,png,pdf
     * @bodyParam passport_document file required Пасспорт директора в виде файла jpg,jpeg,png,pdf
     * @bodyParam state_register_document file required свидетельство о гос реестре компании в виде файла jpg,jpeg,png,pdf
     * @param RegisterRequest $request
     * @return SuccessResponse
     */
    public function store(RegisterRequest $request): SuccessResponse
    {
        $company = $this->companyService->store($request->toDto());

        return new SuccessResponse(
            response: CompanyResource::make($company),
            status: 201,
            message: 'Company created',
        );
    }

    /**
     * Подписка на компанию
     *
     * @urlParam company integer required ID компании. Example: 1
     * @responseFile status=200 storage/responses/company/subscribe.json
     * @param Company $company
     * @return SuccessEmptyResponse
     */
    public function subscribe(Company $company): SuccessEmptyResponse
    {
        $this->companyService->subscribe($company);

        return new SuccessEmptyResponse(
            message: 'Вы успешно подписались'
        );
    }

    /**
     * Отписка от компании
     *
     * @urlParam company integer required ID компании. Example: 1
     * @responseFile status=200 storage/responses/company/unsubscribe.json
     * @param Company $company
     * @return SuccessEmptyResponse
     */
    public function unsubscribe(Company $company): SuccessEmptyResponse
    {
        $this->companyService->unsubscribe($company);

        return new SuccessEmptyResponse(
            message: 'Вы успешно отписались'
        );
    }

    /**
     * Оценка компании
     *
     *
     * @urlParam company_id int required ID компании. Example: 1
     * @bodyParam score int required Оценка. От 1 до 5. Example: 3
     * @responseFile status=201 storage/responses/company/client/score.json
     * @responseFile status=422 scenario="Validation failed" storage/responses/company/client/score-validation-fail.json
     * @param CompanyScoreRequest $request
     * @param Company $company
     * @return SuccessResponse
     */
    public function score(CompanyScoreRequest $request, Company $company): SuccessResponse
    {
        $company = $this->companyService->score($company, $request->get('score'));

        return new SuccessResponse(
            response: CompanyResource::make($company),
            status: Response::HTTP_CREATED,
            message: 'Company scored'
        );
    }

    /**
     * Подтверждения компании
     *
     * @urlParam company integer required ID компании. Example: 1
     * @bodyParam bank_account string required Банковский счет компании. Example: 1234567889123456789
     * @bodyParam tariff_conditions_accepted_at datetime required Дата принятия основного соглашения. Example:
     * @bodyParam basic_agreement_accepted_at datetime required Дата принятия условий стандартного тарифного плана. Example:
     * @responseFile status=201 storage/responses/company/confirmation/confirm.json
     * @responseFile status=422 scenario="Validation failed" storage/responses/company/confirmation/validation-failed.json
     * @param Company $company
     * @param DataConfirmationRequest $request
     * @return SuccessEmptyResponse
     */
    public function dataConfirmation(Company $company, DataConfirmationRequest $request): SuccessEmptyResponse
    {
        $this->companyService->dataConfirmationCompany($company, $request->toDto());

        return new SuccessEmptyResponse(
            message: 'Вы подтвердили компанию'
        );
    }
}
