<?php

namespace App\Tbuy\Menu\Repositories;

use App\Tbuy\Menu\DTOs\MenuDTO;
use App\Tbuy\Menu\Models\Menu;
use Illuminate\Database\Eloquent\Collection;

interface MenuRepository
{
    public function get(): Collection;

    public function create(MenuDTO $payload): Menu;

    public function update(Menu $menu, MenuDTO $payload): Menu;

    public function delete(Menu $menu): void;
}
