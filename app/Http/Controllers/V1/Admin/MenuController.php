<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\SuccessEmptyResponse;
use App\Http\Responses\SuccessResponse;
use App\Tbuy\Menu\Models\Menu;
use App\Tbuy\Menu\Requests\StoreRequest;
use App\Tbuy\Menu\Requests\UpdateRequest;
use App\Tbuy\Menu\Resources\MenuResource;
use App\Tbuy\Menu\Services\MenuService;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Админ
 * @subgroup Меню
 * @authenticated
 */
class MenuController extends Controller
{
    public function __construct(private readonly MenuService $menuService)
    {
    }

    /**
     * Список
     *
     * @responseFile storage/responses/menu/index.json
     * @return SuccessResponse
     */
    public function index(): SuccessResponse
    {
        $menus = $this->menuService->get();

        return new SuccessResponse(
            response: MenuResource::collection($menus),
            message: 'Menu list'
        );
    }

    /**
     * Детальная информация
     *
     * @urlParam id int required ID меню. Example: 1
     * @param Menu $menu
     * @return SuccessResponse
     */
    public function show(Menu $menu): SuccessResponse
    {
        return new SuccessResponse(
            response: MenuResource::make($menu->load(['image', 'children', 'parent'])),
            message: 'Menu detail'
        );
    }

    /**
     * Новое меню
     *
     * @bodyParam name string required Название меню. Example: menu-name
     * @bodyParam menu_id integer ID меню. Example: 1
     * @bodyParam slug string required Slug менюшки. Example: moderacia-produkta
     * @bodyParam image file required Фотография меню
     * @responseFile status=201 storage/responses/menu/create.json
     * @responseFile status=422 scenario="Validation failed" storage/responses/menu/validation-failed.json
     * @param StoreRequest $request
     * @return SuccessResponse
     */
    public function store(StoreRequest $request): SuccessResponse
    {
        $menu = $this->menuService->create($request->toDto());

        return new SuccessResponse(
            response: MenuResource::make($menu),
            status: Response::HTTP_CREATED,
            message: 'Menu created'
        );
    }

    /**
     *
     * Изменение
     *
     * @urlParam id int required ID меню. Example: 1
     * @bodyParam name string required Название меню. Example: menu-name
     * @bodyParam menu_id integer ID меню. Example: 1
     * @bodyParam slug string required Slug менюшки. Example: moderacia-produkta
     * @bodyParam image file Фотография меню
     * @responseFile storage/responses/menu/update.json
     * @responseFile status=422 scenario="Validation failed" storage/responses/menu/validation-failed.json
     * @param UpdateRequest $request
     * @param Menu $menu
     * @return SuccessResponse
     */
    public function update(UpdateRequest $request, Menu $menu): SuccessResponse
    {
        $menu = $this->menuService->update($menu, $request->toDto());

        return new SuccessResponse(
            response: MenuResource::make($menu),
            message: 'Menu updated'
        );
    }

    /**
     *
     * Удаление
     *
     * @urlParam id int required ID меню. Example: 1
     * @responseFile storage/responses/menu/delete.json
     * @param Menu $menu
     * @return SuccessEmptyResponse
     */
    public function destroy(Menu $menu): SuccessEmptyResponse
    {
        $this->menuService->delete($menu);

        return new SuccessEmptyResponse(
            message: 'Menu deleted'
        );
    }
}
