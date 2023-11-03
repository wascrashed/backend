<?php

namespace Database\Seeders;

use App\Tbuy\Menu\Models\Menu;
use Illuminate\Database\Seeder;

class ProductModerationMenuSeeder extends Seeder
{
    protected array $menus = [
        [
            'name' => 'Заявки на новый продукт',
            'slug' => '/invites',
        ],
        [
            'name' => 'Отклоненные продукты',
            'slug' => '/declined-products',
        ],
        [
            'name' => 'Продукты у которых нет остатка',
            'slug' => '/no-reminder',
        ],
        [
            'name' => 'Последние 100 одобренных продуктов',
            'slug' => '/last-100-accepted-products',
        ],
        [
            'name' => 'Активные продукты',
            'slug' => '/active-products',
        ],
        [
            'name' => 'Неактивные продукты',
            'slug' => '/inactive-products',
        ],
        [
            'name' => 'Заявки на новый бренд',
            'slug' => '/brand-invite',
        ],
        [
            'name' => 'Одобренные бренды',
            'slug' => '/accepted-brands',
        ],
        [
            'name' => 'Отклоненные бренды',
            'slug' => '/declined-brands',
        ],
        [
            'name' => 'Отклоненные компаний',
            'slug' => '/declined-companies'
        ],
        [
            'name' => 'Архив отклоненных брендов',
            'slug' => '/archive/declined-brands',
        ],
        [
            'name' => 'Архив отклоненных компаний',
            'slug' => '/archive/declined-companies'
        ]
    ];

    public function run(): void
    {
        $date = now()->toDateTimeString();

        $parent = Menu::query()->create([
            'name' => 'Модерация продуктов',
            'slug' => '/products/moderation'
        ]);

        Menu::query()->insert(array_map(function (array $item) use($parent, $date) {
            return $item + [
                'menu_id' => $parent->id,
                'created_at' => $date,
                'updated_at' => $date
            ];
        }, $this->menus));
    }
}
