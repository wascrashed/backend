<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\SuccessResponse;
use App\Tbuy\Settings\Models\Settings;
use App\Tbuy\Settings\Repositories\SettingsRepository;
use App\Tbuy\Settings\Requests\UpdateRequest;
use App\Tbuy\Settings\Resources\SettingsResource;
use App\Tbuy\Settings\Services\SettingsService;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Поиск
 * @subgroup Настройки
 * @authenticated
 */
class SettingsController extends Controller
{
    public function __construct(
        protected readonly SettingsService    $settingsService
    ) {
    }

    /**
     * Список настроек
     *
     * @responseFile storage/responses/settings/index/response.json

     * @return SuccessResponse
     */
    public function index(): SuccessResponse
    {
        $settings = $this->settingsService->get();

        return new SuccessResponse(
            response: SettingsResource::collection($settings),
            message: 'Список настроек'
        );
    }

    /**
     * Информация о настройке
     *
     * @urlParam product integer required ID продукта. Example: 1
     * @param Settings $settings
     * @return SuccessResponse
     */
    public function show(Settings $settings): SuccessResponse
    {
        return new SuccessResponse(
            response: SettingsResource::make($settings),
            message: 'Полная информация о настроеке'
        );
    }

    /**
     * Редактирование настройки
     *
     * @param UpdateRequest $request
     * @param Settings $settings
     * @return SuccessResponse
     */
    public function update(UpdateRequest $request, Settings $settings): SuccessResponse
    {
        $product = $this->settingsService->update($request->toDto(), $settings);

        return new SuccessResponse(
            response: SettingsResource::make($product),
            message: 'Настройка успешно обновлена'
        );
    }
}
