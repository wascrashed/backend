<?php

namespace App\Http\Controllers\V1\Client;

use App\Http\Controllers\Controller;
use App\Http\Responses\SuccessEmptyResponse;
use App\Http\Responses\SuccessResponse;
use App\Tbuy\Company\Models\Company;
use App\Tbuy\Filial\Models\Filial;
use App\Tbuy\Filial\Requests\FilialRequest;
use App\Tbuy\Filial\Resources\FilialResource;
use App\Tbuy\Filial\Services\FilialService;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Клиент
 * @subgroup Филиалы
 * @authenticated
 */
class FilialController extends Controller
{
    public function __construct(private readonly FilialService $filialService)
    {
    }

    /**
     * Список
     *
     * @urlParam company_id int required ID компании. Example: 1
     * @responseFile storage/responses/company/filial/index.json
     * @param Company $company
     * @return SuccessResponse
     */
    public function index(Company $company): SuccessResponse
    {
        $filials = $this->filialServiceWithCompany($company)->getListWithCache();

        return new SuccessResponse(
            response: FilialResource::collection($filials),
            message: 'Filial list'
        );
    }

    /**
     * Новый филиал
     *
     * @urlParam company_id int required ID компании. Example: 1
     * @bodyParam name object required Список названий на разных языках
     * @bodyParam name.en string required Название на английском. Example: Name en
     * @bodyParam name.hy string required Название на армянском. Example: Name hy
     * @bodyParam name.ru string required Название на русском. Example: Name ru
     * @bodyParam phone string required Номер телефона. Example: +123-123-12-12
     * @bodyParam address string required Адрес. Example: Some address 14-12
     * @bodyParam coordinates object required Объект координат
     * @bodyParam coordinates.latitude string required Координаты широты. Example: 30.0595563
     * @bodyParam coordinates.longitude string required Координаты долготы. Example: 31.217179
     * @bodyParam schedule array required Список режима работы по дням.
     * @bodyParam schedule.0 object required Объект режима работы.
     * @bodyParam schedule.0.open_at string required Время открытия. Example: 09:00
     * @bodyParam schedule.0.close_at string required Время закрытия. Example: 21:00
     * @bodyParam schedule.0.day int required День недели:<br/>
     * <b>1</b> - Понедельник<br/>
     * <b>2</b> - Вторник<br/>
     * <b>3</b> - Среда<br/>
     * <b>4</b> - Четверг<br/>
     * <b>5</b> - Пятница<br/>
     * <b>6</b> - Суббота<br/>
     * <b>7</b> - Воскресенье<br/>
     * Example: 1
     * @bodyParam is_main bool required Главный филиал или нет. Example: true
     * @bodyParam community_id int required ID сообщества. Example: 1
     * @bodyParam region_id int required ID региона. Example: 1
     * @responseFile status=201 storage/responses/company/filial/create.json
     * @responseFile status=422 scenario="Validation-failed" storage/responses/company/filial/validation-failed.json
     * @param FilialRequest $request
     * @param Company $company
     * @return SuccessResponse
     */
    public function store(FilialRequest $request, Company $company): SuccessResponse
    {
        $filial = $this->filialServiceWithCompany($company)->createAndClearCache($request->toDto());

        return new SuccessResponse(
            response: FilialResource::make($filial),
            status: Response::HTTP_CREATED,
            message: 'Filial created'
        );
    }

    /**
     * Изменить филиал
     *
     * @urlParam company_id int required ID компании. Example: 1
     * @urlParam id int required ID филиала. Example: 1
     * @bodyParam name object required Список названий на разных языках
     * @bodyParam name.en string required Название на английском. Example: Name en
     * @bodyParam name.hy string required Название на армянском. Example: Name hy
     * @bodyParam name.ru string required Название на русском. Example: Name ru
     * @bodyParam phone string required Номер телефона. Example: +123-123-12-12
     * @bodyParam address string required Адрес. Example: Some address 14-12
     * @bodyParam coordinates object required Объект координат
     * @bodyParam coordinates.latitude string required Координаты широты. Example: 30.0595563
     * @bodyParam coordinates.longitude string required Координаты долготы. Example: 31.217179
     * @bodyParam schedule array required Список режима работы по дням.
     * @bodyParam schedule.0 object required Объект режима работы.
     * @bodyParam schedule.0.open_at string required Время открытия. Example: 09:00
     * @bodyParam schedule.0.close_at string required Время закрытия. Example: 21:00
     * @bodyParam schedule.0.day int required День недели:<br/>
     * <b>1</b> - Понедельник<br/>
     * <b>2</b> - Вторник<br/>
     * <b>3</b> - Среда<br/>
     * <b>4</b> - Четверг<br/>
     * <b>5</b> - Пятница<br/>
     * <b>6</b> - Суббота<br/>
     * <b>7</b> - Воскресенье<br/>
     * Example: 1
     * @bodyParam is_main bool required Главный филиал или нет. Example: true
     * @bodyParam community_id int required ID сообщества. Example: 1
     * @bodyParam region_id int required ID региона. Example: 1
     * @responseFile storage/responses/company/filial/update.json
     * @responseFile status=422 scenario="Validation-failed" storage/responses/company/filial/validation-failed.json
     * @responseFile status=404 scenario="Company ID mismatch with company ID of filial" storage/responses/company/filial/company-id-mismatch.json
     * @param FilialRequest $request
     * @param Company $company
     * @param Filial $filial
     * @return SuccessResponse
     */
    public function update(FilialRequest $request, Company $company, Filial $filial): SuccessResponse
    {
        $filial = $this->filialServiceWithCompany($company)->updateAndClearCache($filial, $request->toDto());

        return new SuccessResponse(
            response: FilialResource::make($filial),
            message: 'Filial updated'
        );
    }

    /**
     * Удалить филиал
     *
     * @urlParam company_id int required ID компании. Example: 1
     * @urlParam id int required ID филиала. Example: 1
     * @responseFile storage/responses/company/filial/delete.json
     * @responseFile status=404 scenario="Company ID mismatch with company ID of filial" storage/responses/company/filial/company-id-mismatch.json
     * @param Company $company
     * @param Filial $filial
     * @return SuccessEmptyResponse
     */
    public function destroy(Company $company, Filial $filial): SuccessEmptyResponse
    {
        $is_deleted = $this->filialServiceWithCompany($company)->deleteAndClearCache($filial);

        return new SuccessEmptyResponse(
            message: $is_deleted ? 'Filial deleted' : 'Filial not deleted'
        );
    }

    private function filialServiceWithCompany(Company $company): FilialService
    {
        return $this->filialService->setCompany($company);
    }
}
