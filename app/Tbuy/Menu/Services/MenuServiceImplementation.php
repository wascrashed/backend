<?php

namespace App\Tbuy\Menu\Services;

use App\Tbuy\MediaLibrary\Enums\MediaLibraryCollection;
use App\Tbuy\MediaLibrary\Repositories\MediaLibraryRepository;
use App\Tbuy\Menu\DTOs\MenuDTO;
use App\Tbuy\Menu\Enums\CacheKey;
use App\Tbuy\Menu\Models\Menu;
use App\Tbuy\Menu\Repositories\MenuRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MenuServiceImplementation implements MenuService
{
    public function __construct(
        private readonly MediaLibraryRepository $libraryRepository,
        private readonly MenuRepository         $menuRepository
    )
    {
    }

    public function get(): Collection
    {
        return Cache::remember(
            CacheKey::MENU_LIST->value,
            CacheKey::ttl(),
            fn() => $this->menuRepository->get()
        );
    }

    public function create(MenuDTO $payload): Menu
    {
        $menu = DB::transaction(function () use ($payload) {
            $menu = $this->menuRepository->create($payload);

            $this->libraryRepository->addMedia($menu, $payload->image, MediaLibraryCollection::MENU_IMAGE);

            return $menu;
        });

        Cache::forget(CacheKey::MENU_LIST->value);

        return $menu;
    }

    public function update(Menu $menu, MenuDTO $payload): Menu
    {
        $menu = DB::transaction(function () use ($menu, $payload) {
            $menu = $this->menuRepository->update($menu, $payload);

            if ($payload->image) {
                $this->libraryRepository->delete($menu, MediaLibraryCollection::MENU_IMAGE);
                $this->libraryRepository->addMedia($menu, $payload->image, MediaLibraryCollection::MENU_IMAGE);
            }

            return $menu;
        });

        Cache::forget(CacheKey::MENU_LIST->value);

        return $menu;
    }

    public function delete(Menu $menu): void
    {
        DB::transaction(function () use ($menu) {
            $this->menuRepository->delete($menu->load('children'));
        });

        Cache::forget(CacheKey::MENU_LIST->value);
    }
}
