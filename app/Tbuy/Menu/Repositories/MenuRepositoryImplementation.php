<?php

namespace App\Tbuy\Menu\Repositories;

use App\Tbuy\Menu\DTOs\MenuDTO;
use App\Tbuy\Menu\Models\Menu;
use Illuminate\Database\Eloquent\Collection;

class MenuRepositoryImplementation implements MenuRepository
{
    public function get(): Collection
    {
        return Menu::query()
            ->whereNull('menu_id')
            ->with(['image', 'grandChildren', 'parent'])
            ->get();
    }

    public function create(MenuDTO $payload): Menu
    {
        $menu = new Menu([
            'name' => $payload->name,
            'menu_id' => $payload->menu_id
        ]);
        $menu->save();

        return $menu;
    }

    public function update(Menu $menu, MenuDTO $payload): Menu
    {
        $menu->fill([
            'name' => $payload->name,
            'menu_id' => $payload->menu_id
        ]);
        $menu->save();

        return $menu;
    }

    public function delete(Menu $menu): void
    {
        $menu->delete();
    }
}
