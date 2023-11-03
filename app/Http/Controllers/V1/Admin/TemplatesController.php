<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\SuccessEmptyResponse;
use App\Http\Responses\SuccessResponse;
use App\Tbuy\Templates\Models\Templates;
use App\Tbuy\Templates\Requests\StoreRequest;
use App\Tbuy\Templates\Requests\UpdateRequest;
use App\Tbuy\Templates\Resources\TemplatesResource;
use App\Tbuy\Templates\Services\TemplatesService;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Админ
 * @subgroup Баннер
 * @authenticated
 */
class TemplatesController extends Controller
{
    public function __construct(
        private readonly TemplatesService $templatesService
    )
    {
    }

    /**
     * Список
     *
     * @responseFile storage/responses/templates/index.json
     */
    public function index(): SuccessResponse
    {
        $templatess = $this->templatesService->getWithCache();

        return new SuccessResponse(
            response: TemplatesResource::collection($templatess),
            message: 'Templates list'
        );
    }

    /**
     * Новый баннер
     *
     * @bodyParam name object required
     * @bodyParam name.ru string required Название баннера на русском. Example: баннер
     * @bodyParam name.en string required Название баннера на английском. Example: templates
     * @bodyParam name.hy string required Название баннера на армянском. Example: templates-hy
     * @bodyParam banner_id int required Баннер айди
     * @responseFile status=201 storage/responses/templates/create.json
     * @responseFile status=422 scenario="Validation failed" storage/responses/templates/validation-failed.json
     */
    public function store(StoreRequest $request): SuccessResponse
    {
        $templates = $this->templatesService->createAndClearCache($request->toDto());

        return new SuccessResponse(
            response: TemplatesResource::make($templates),
            status: Response::HTTP_CREATED,
            message: 'Templates created'
        );
    }

    /**
     * Просмотр
     *
     * @urlParam templates_id int required ID темплейта. Example: 1
     * @responseFile storage/responses/templates/show.json
     */
    public function show(Templates $templates): SuccessResponse
    {
        return new SuccessResponse(
            response: TemplatesResource::make($templates),
            message: 'Templates detail'
        );
    }

    /**
     * Изменить
     *
     * @urlParam templates_id int required ID баннера. Example: 1
     * @bodyParam name object required
     * @bodyParam name.ru string required Название баннера на русском. Example: баннер
     * @bodyParam name.en string required Название баннера на английском. Example: templates
     * @bodyParam name.hy string required Название баннера на армянском. Example: templates-hy
     * @bodyParam banner_id int required Темплейт
     * @responseFile status=201 storage/responses/templates/update.json
     * @responseFile status=422 scenario="Validation failed" storage/responses/templates/validation-failed.json
     */
    public function update(UpdateRequest $request, Templates $templates): SuccessResponse
    {
        $templates = $this->templatesService->updateAndClearCache($templates, $request->toDto());

        return new SuccessResponse(
            response: TemplatesResource::make($templates),
            message: 'Templates updated'
        );
    }

    /**
     * Удалить
     *
     * @urlParam templates_id int required ID темплейта. Example: 1
     * @response {"success": true, "message": "Templates deleted"}
     */
    public function destroy(Templates $templates): SuccessEmptyResponse
    {
        $this->templatesService->deleteAndClearCache($templates);

        return new SuccessEmptyResponse(
            message: "templates deleted"
        );
    }
}
