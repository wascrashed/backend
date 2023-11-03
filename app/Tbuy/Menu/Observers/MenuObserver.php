<?php

namespace App\Tbuy\Menu\Observers;

use App\Tbuy\Menu\Models\Menu;
use Illuminate\Support\Str;

class MenuObserver
{
    public function creating(Menu $menu): void
    {
        $menu->slug = Str::of($menu->slug)->slug()->prepend('/');
    }

    public function updating(Menu $menu): void
    {
        $menu->slug = Str::of($menu->slug)->slug()->prepend('/');
    }

    public function deleting(Menu $menu): void
    {
        $menu->children->each(fn(Menu $menu) => $menu->delete());
    }
}
