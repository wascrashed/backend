<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\SuccessResponse;
use App\Tbuy\Locale\Models\Locale;
use App\Tbuy\Locale\Requests\StoreRequest;
use App\Tbuy\Locale\Requests\UpdateRequest;
use App\Tbuy\Locale\Resources\LocaleResource;
use App\Tbuy\Locale\Services\LocaleService;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Админ
 * @subgroup Языки
 * @authenticated
 */
class LocaleController extends Controller
{
    public function __construct(private readonly LocaleService $localeService)
    {
    }

    /**
     * Список
     *
     * @responseFile storage/responses/locale/index.json
     * @return SuccessResponse
     */
    public function index(): SuccessResponse
    {
        $locales = $this->localeService->get();

        return new SuccessResponse(
            response: LocaleResource::collection($locales),
            message: 'Locale list'
        );
    }

    /**
     * Детальная информация
     *
     * @urlParam id int required ID языка. Example: 1
     * @responseFile storage/responses/locale/show.json
     * @param Locale $locale
     * @return SuccessResponse
     */
    public function show(Locale $locale): SuccessResponse
    {
        return new SuccessResponse(
            response: LocaleResource::make($locale),
            message: 'Locale detail'
        );
    }

    /**
     * Новый язык
     *
     * @bodyParam name string required Название языка. Example: Русский
     * @bodyParam locale string required Код языка. Example: ru
     * @responseFile status=201 storage/responses/locale/create.json
     * @responseFile status=422 scenario="Validation failed" storage/responses/locale/validation-failed.json
     * @param StoreRequest $request
     * @return SuccessResponse
     */
    public function store(StoreRequest $request): SuccessResponse
    {
        $locale = $this->localeService->create($request->toDto());

        return new SuccessResponse(
            response: LocaleResource::make($locale),
            status: Response::HTTP_CREATED,
            message: 'Locale created'
        );
    }

    /**
     * Изменение языка
     *
     * @urlParam id int required ID языка. Example: 1
     * @bodyParam name string required Название языка. Example: Русский
     * @bodyParam locale string required Код языка. Example: ru
     * @responseFile status=200 storage/responses/locale/update.json
     * @responseFile status=422 scenario="Validation failed" storage/responses/locale/validation-failed.json
     * @param UpdateRequest $request
     * @param Locale $locale
     * @return SuccessResponse
     */
    public function update(UpdateRequest $request, Locale $locale): SuccessResponse
    {
        $locale = $this->localeService->update($locale, $request->toDto());

        return new SuccessResponse(
            response: LocaleResource::make($locale),
            message: 'Locale updated'
        );
    }
}
