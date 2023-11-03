<?php

namespace Database\Seeders;

use App\Tbuy\MediaLibrary\Enums\MediaLibraryCollection;
use App\Tbuy\Menu\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;

class MenuSeeder extends Seeder
{
    protected array $menus = [
        [
            'menu' => [
                'name' => 'Товары',
                'is_active' => false,
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Новые Товары',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Отклоненные товары',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Отклоненные бренды',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Последние 100 одобренные товары',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Все активне товары',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Аналогические товары',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Товары С нулевым остатком',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Неактивные товары',
                        'is_active' => false
                    ],
                    'children' => []
                ],
            ]
        ],
        [
            'menu' => [
                'name' => 'Проверка товаров',
                'is_active' => false,
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Наличие бренда в модели',
                        'is_active' => false,
                    ],
                    'children' => [],
                ],
                [
                    'menu' => [
                        'name' => 'С повторяющимися именами',
                        'is_active' => false,
                    ],
                    'children' => [],
                ],
                [
                    'menu' => [
                        'name' => 'Товары с длинными именами',
                        'is_active' => false,
                    ],
                    'children' => [],
                ],
                [
                    'menu' => [
                        'name' => 'Товары с одинаковым названием, но разными фильтрами',
                        'is_active' => false,
                    ],
                    'children' => [],
                ],
                [
                    'menu' => [
                        'name' => 'Обязательная отметка с меньшим количеством фильтров',
                        'is_active' => false,
                    ],
                    'children' => [],
                ],
                [
                    'menu' => [
                        'name' => 'Содержит одинаковые фото',
                        'is_active' => false,
                    ],
                    'children' => [],
                ],
                [
                    'menu' => [
                        'name' => 'С меньшим, чем минимальное изображение',
                        'is_active' => false,
                    ],
                    'children' => [],
                ],
                [
                    'menu' => [
                        'name' => 'Фото плохого качества',
                        'is_active' => false,
                    ],
                    'children' => [],
                ],
                [
                    'menu' => [
                        'name' => 'Содержит взаимосвязние фильтры',
                        'is_active' => false,
                    ],
                    'children' => [],
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Аналитика товаров',
                'is_active' => false
            ]
        ],
        [
            'menu' => [
                'name' => 'Аналитика рекламных товаров',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Специальное предложение',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Акция с подарком',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Скидка',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Срочные акции',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Дерево категорий товаров',
                'is_active' => false,
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Настройки категории',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Проверка категорий товаров',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Фильтры товаров',
                'is_active' => false,
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Добавить новый фильтр',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Бренды:',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Глобальные фильтры',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Все фильтры',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Меры измерения',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Типы фильтров',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Определение контента 18+ по категориям',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Страны-производители:',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Марки и модели автомобилей',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Проверка фильтра товаров',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Аналитика категорий',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Аналитика фильтров',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Подарочная карта онлайн',
                'is_active' => false,
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Покупка',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Активный',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Купленные/подаренные карты',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Загрузить/архив шаблона',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Пожертвования',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Перерподарено',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Настройки подарочных карт',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Аналитика подарочных карт',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Сравнительная аналитика',
                'is_active' => false,
            ],
            'children' => [
            ]
        ],
        [
            'menu' => [
                'name' => 'Аналитика лайков',
                'is_active' => false,
            ],
            'children' => [
            ]
        ],
        [
            'menu' => [
                'name' => 'Аналитика комментариев',
                'is_active' => false,
            ],
            'children' => [
            ]
        ],
        [
            'menu' => [
                'name' => 'Аналитика товаров в корзине',
                'is_active' => false,
            ],
            'children' => [
            ]
        ],
        [
            'menu' => [
                'name' => 'Главый Банер Домашней страница',
                'is_active' => false,
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Новый Банер',
                        'is_active' => false,
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Отклоненные',
                        'is_active' => false,
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Активный/архивный',
                        'is_active' => false,
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Вход возрастное ограничение',
                        'is_active' => false,
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Вход в регион',
                        'is_active' => false,
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Вход по полу',
                        'is_active' => false,
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Cat-Fish Банер',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Новый Cat-Fish Банер',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Отклоняено Cat-Fish',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Активный/архивный',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Вход возрастное ограничение',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Вход в регион',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Вход по полу',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Рекламные СМС сообщения',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Новое уведомление',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Отклоненные',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Активный/архивный',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Вход возрастное ограничение',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Вход в регион',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Вход по полу',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Рассылки Viber',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Новое Рассылкa',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Отклоненные',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Активный/архивный',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Вход возрастное ограничение',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Вход в регион',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Вход по полу',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Рассылки Telegram',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Новое Рассылкa',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Отклоненные',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Активный/архивный',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Вход возрастное ограничение',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Вход в регион',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Вход по полу',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Рассылки WhatsApp',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Новое Рассылкa',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Отклоненные',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Активный/архивный',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Вход возрастное ограничение',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Вход в регион',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Вход по полу',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Рассылки на Email',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Новое Рассылкa',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Отклоненные',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Активный/архивный',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Вход возрастное ограничение',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Вход в регион',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Вход по полу',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Реклама Промо Рассылки',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Новое Рассылкa',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Отклоненные',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Активный/архивный',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Вход возрастное ограничение',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Вход в регион',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Вход по полу',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Маркетинг',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Дня Рождения',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Настройки Дня рождения',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Аналитика Дня рождения',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'TBUY Настройки годового планирования сайта',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Аналитика годового планирования для сайта TBUY',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Создать рекламы на сайте TBUY',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Создать новый главный обои',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Архив всех Банеров на главной странице TBUY',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Cat-Fish новые баннер',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'TBUY Архив всех баннеров Cat-Fish',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Архив все обоев организации',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Аналитика банера в странице органзации',
                        'is_active' => false
                    ],
                    'children' => []
                ],
            ]
        ],
        [
            'menu' => [
                'name' => 'Рассилки Отправленые с TBUY',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'SMS',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Viber',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'WhatsApp',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Telegram',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Promo',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Email',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Аналитикa Рассылок от TBUY',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Вакансии в TBUY',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Создать новое заявки',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Все объявления о вакансии работодателей в TBUY',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Аналитика вакансий в TBUY',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Обжалование',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Новое обжалование',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Текущие обжалование',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Архив жалоб',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Аналитика обжалование',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Настройки обжалования',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Словарь и языки',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Слова страницы компании',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Тексты страницы компании',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Слова веб-сайта TBUY',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Тексты веб-сайта TBUY',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Статические слова и тексты в приложении TBUY',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Коммерческие слова и тексты',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Слова доставки и тексты',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Вставка слов и текстов',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Категории товаров',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Категории услуг',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Категории вакансий',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Фильтры товаров',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Фильтры услуг',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Фильтры вакансий',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Подфильтры товаров',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Подфильтры Услуг',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Подфильтры вакансий',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Promo-страницы',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Слова/тексты страницы администрации',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Структура языков',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Дополнения языков',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Проверки языков',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Аналитика языков',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Услуги',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Настройки категорий услуг',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Аналитика категории услуг',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Проверка категории услуг',
                        'is_active' => false
                    ],
                    'children' => []
                ],
            ]
        ],
        [
            'menu' => [
                'name' => 'Сервисные фильтры',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Добавить фильтр',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Все фильтры',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Типы фильтров',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Глобальный фильтр',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Проверка фильтров услуг',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Аналитика фильтров услуг',
                        'is_active' => false
                    ],
                    'children' => []
                ],
            ]
        ],
        [
            'menu' => [
                'name' => 'Объявления на услуг',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Новый',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Последние 100',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Отклоненные услуги',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Активные',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Неактивные',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Аналитика услуг',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Дерево категорий вакансий',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Настройки Категории Вакансии',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Проверка категорий вакансий',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Аналитика категорий вакансий',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Фильтры категорий вакансий',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Добавить фильтр',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Все фильтры',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Типы фильтров',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Глобальный фильтр',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Проверка фильтров вакансий',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Аналитика фильтров вакансий',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Пользователи',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Все пользователи',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Способ покупки',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Все покупки',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'С кредитом',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'С платежными системами',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Банковская картой',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Наличные',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Трансферомй',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Аналитика покупок',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Региональная аналитика',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Финансовый аналитика',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Сезонность',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'По категориям',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Продавец: Физическое лицо',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Новая заявка на регистрацию',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Отклоненные',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Последние 50 одобренные',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Все продающие физические лица',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Ежедневные источники дохода в кошельке Физ. лиц',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Расход средств с кошельков',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Покупка тарифного пакета',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'СМС-сообщение',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Сообщение в Viber',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Сообщение в WhatsApp',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Программа Telegram',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Сообщение Email',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Promo программа',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Покупка акций',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Обновления продуктов',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Аналитика продавца физических лиц',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Аналитика продаж',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Аналитика страницы физ.лиц в TBUY',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Тарифный пакет',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Объявления',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Рассылки',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Подпысчики',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Социальное: сети',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Восполнимость страницы',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Источники кликов для категорий товаров, продаваемых по количеству',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Количество добавлений товаров в категорию по времени',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Объявления о вакансиях',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Новое заявки',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Отклоненные заявки',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Архив о заявлениях на работу',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Проверка поиска работы',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Аналитика поиска работы',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Устройства доступа',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'IMEI и модель телефона устройств, к которым осуществляется доступ',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Расположение устройств, к которым осуществляется доступ, по времени',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'MAC-адрес модуля WIFI устройства',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'MAC-адрес WIFI, к которому он подключен',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'MAC-адрес Bluetooth-устройства',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Название и версия браузера',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Время показание на устройстве',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Выходной IP устройства',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Доступ с WIFI-а или нет?',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Номер или номера, установленные на устройстве',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Отгрузка',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Регистрация грузоотправителей',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Кошельки грузоотправителей',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Отправлено по названию компании',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Заказы, отправленные с опозданием компанией TBUY',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Аналитика доставки',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Принятие доставки',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Ежечасно',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Загрузка и удаление приложений',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => '24 часа заявки TBUY',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => '24 часа установки модуля',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Модуль доставки 24 часа',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => '24 часа коммерческого модуля',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => '24 часа модуля резюме',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => '24 часа ресторанного модуля',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Продавец Индивидуальный модуль 24 часа',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Модуль 24 часа объявлений',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Настройки приложения',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Аналитика приложений',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Организации',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Список филиалов',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Новый филиал',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Новый магазины',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Новый компании услуг',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Отклоненные Магазины',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Отклоненные компании услуг',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Последние 50 Магазины',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Последние 50 компании услуг',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Новый представитель бренда',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Все представителы брендов',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Отклоненные представителство',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Неактивные магазины',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Неактивные компании услуг',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Активные магазины',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Активные компании услуг',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Настройки внутренней страницы организации',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Редактирование Тарифного пакета магазинов',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Редактирование Тарифного пакета компании услуг',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Редактирование договоров и соглашений',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Аналитика организации',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Внутренняя аналитика программы',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Аналитика продаж',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Аналитика своей веб-страницы',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Аналитика тарифных планов',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Сервисная аналитика',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Аналитика рекламы сома для организации',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Анализ банеров на странице компании в TBUY-е',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Аналитика рекламы на главной странице TBUY по организациям',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Аналитика объявлений о вакансиях',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Поставки, осуществляемые организацией',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Онлайн-аналитика подарочных карт организации',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Аналитика записей организации',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Отсутствие товара у Организации на момент продажи',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Аналитика социальных сетей организации',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Аналитика занятости страниц',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Внутренняя аналитика администратора',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Источники кликов из категорий, где он продае',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Количество добавлений товаров в категорию по времени',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Кошельки организации',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Записи и источники в кошельки организации',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Вывод средств с кошельков организаций',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Покупка тарифного пакета',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Для покупки банеров в Главней странице',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Cat-Fish банеров',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'СМС-сообщение',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Сообщение в Viber',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Сообщение в WhatsApp',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Программа Telegram',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Сообщение Email',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Promo',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Покупка акций',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Обновления',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Вакансии организации',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Новое приложение',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Отклоненные заявки',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Архив Вакансии',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Проверки вакансий',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Аналитика вакансий',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Аналитика посещений TBUY',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Источники и их среднее время',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Вторичные входы',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Аналитика аномальных пиков',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Обнаружение ботов',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Гугл Аналитика',
                'is_active' => false
            ],
            'children' => []
        ],
        [
            'menu' => [
                'name' => 'Яндекс Метрики',
                'is_active' => false
            ],
            'children' => []
        ],
        [
            'menu' => [
                'name' => 'Кредитно-идентификационный модуль',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Загрузите и отредактируйте банковские данные и логотип',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Банковская аналитика',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'База данных электронных подписей и их кодов',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Аналитика блока идентификации',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Настройки блока идентификации',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Статистика сбоев',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Отключение Интернета',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Сбой модуля',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Сбой приложений',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Поиски',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Настройки поиска в реальном времени',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Настройки результатов поиска',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Aналитика поиска в реальном времени',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Аналитика результатов поиска',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Внутренний чат',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Активные чаты',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Архив внутреннего чата',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Аналитика чата',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Настройки чата',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Настройки в TBUY',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Настройки модуля уставоки',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Страна/провинция/город/изменить',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Все настройки уведомлений в TBUY',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Продающим организациям',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Компания услуг',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Персоналу TBUY',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'покупателям',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Индивидуальные продавцы',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Грузоотправителям',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Коммерческие менеджеры',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Уведомления для установщиков',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Уведомления о подарочной карте',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Электронные письма с подписки на странице TBUY',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Определения тарифных значений',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Цена акций',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Установка тарифов на доставку',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Стоимость и срок обновления',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Редактирование тарифных пакетов и установка цен',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Установление цен на рассылки',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Установка тарифов na установки',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Установка расценок на рекламу по таргетингу',
                        'is_active' => false
                    ],
                    'children' => []
                ],
            ]
        ],
        [
            'menu' => [
                'name' => 'Промо-страницы',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Вход на промо-страницу',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Редактирование промо-страниц',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Аналитика промо-страниц',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Определение рейтингов',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Продукт',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Марка',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'В продающую организацию',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Сервисная организация',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Продавец физическое лицо',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Категория',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Банки',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Мастер Установщик',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Аналитика рейтингов',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Товар',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Бренд',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'В продающую организацию',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Сервисная организация',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Продавец физическое лицо',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Категория',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Банки',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Мастер Установщик',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'SEO-система',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'SEO статических страниц',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Алгоритмы и предложения SEO категории продукта',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Категория продукта и 1 фильтр SEO',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Категория продукта и 2 фильтра SEO',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Категория продукта и 3 фильтра SEO',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'SEO-алгоритмы и предложения категории услуг',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Категория услуги и 1 фильтр SEO',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Категория услуги и 2 фильтра SEO',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Категория услуги и 3 фильтра SEO',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'SEO-алгоритмы и предложения для категории вакансий',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'СТРАНИЦА организации SEO',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'SEO СТРАНИЦЫ организации и ее товарных категорий',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'SEO СТРАНИЦЫ организации и ее категорий услуг',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'SEO изображений',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Часто задаваемые вопросы по SEO',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'SEO промо-страниц',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'SEO-продвижение продукта',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'SEO-аналитика',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Проблемы с SEO-страницами',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Добавьте SEO-чекеры с API для анализа',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'SEO-анализ, созданный на других языках',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Количество проиндексированных страниц в день/ google/yandex',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'TBUY установки',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Регистрация мастера',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Зарегистрированные мастера',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Отправлено на установку',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Установлен',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'просроченные установки',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Все отмененные установки',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Аналитика мастеров TBUY',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Коммерческое приложение',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Регистрация коммерческого сотрудника',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Все коммерческие сотрудники',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Внесение списка организаций',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Аналитика коммерческих сотрудников',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Кошелек TBUY',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Общий отчет по кошельку TBUY',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Вводы из других кошельков в кошелек TBUY',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Магазина',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Компания услуг',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'физ.лицо продавец',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'грузоотправителей',
                        'is_active' => false
                    ],
                    'children' => []
                ],
            ]
        ],
        [
            'menu' => [
                'name' => 'Переводы на кошельки коммерческих сотрудников',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Трансферы (24 часа)',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'В ожидании перевода',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Заявление о переводах',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Переводы монтажникам',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Трансферы (24 часа)',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'В ожидании перевода',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Заявление о переводах',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Переводы на счет организации',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Трансферы (24 часа)',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'В ожидании перевода',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Заявление о переводах',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Переводы на счет сотрудников TBUY',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Трансферы (24 часа)',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'В ожидании перевода',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Заявление о переводах',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Переводы отмененных транзакций',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Пользователи отмененных покупок',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Пользователям отмененных установок',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Возвраты покупателям',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Продавец на физические кошельки Переводы',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Осуществленные переводы (в течение 24 часов)',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'В ожидании перевода',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Аналитика сделок продавцов',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Доход TBUY по типу',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Агент по продажам',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Продажа Организация. продажа тарифных пакетов.',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Слуга. Организация: продажа тарифных пакетов.',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Из премиального пакета Продавца Индивидуального',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'От комиссий из TBUY установок',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'От комиссионных с продаж до частных лиц',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Брокер подарочных карт онлайн',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Из поставок',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Брокер рекламных объявлений',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Из обновлений',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Из рекламных акций',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Аналитика финансовых затрат',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Заработная плата',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Транспортные расходы',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Маркетинговые расходы',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Налоги и расходы',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'незапланированный',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Приобретение оборудования',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Аренда помещений',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Приобретение транспорта',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Юридический',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Административный',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Экономичный',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Дизайнер',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Коммуникация',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Бухгалтерские услуги',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Аналитика выплаченных комиссий',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Представительские расходы',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Список автоматических коробок передач',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Настройки автоматической коробки передач',
                        'is_active' => false
                    ],
                    'children' => []
                ],
            ]
        ],
        [
            'menu' => [
                'name' => 'Отмененные транзакции',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Отмененные',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Аналитика отмененных транзакций',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Отсутствие продукта',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'непоследовательность',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Брошенный до доставки',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Неполная доставка',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'В течение 14 дней без причины',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Юридический блок',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Все контракты',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Организации, скачавшие контракты',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Архив всех Трехсторонних фактуры',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Электронные квитанции о доставке / палец-покупатель',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Электронные акты приема-передачи / Грузоотправитель-покупатель',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Электронные квитанции о доставке / Доставка',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Документы, подтверждающие представительство',
                        'is_active' => false
                    ],
                    'children' => []
                ],
            ]
        ],
        [
            'menu' => [
                'name' => 'Блок дизайна',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Выгрузка шаблонов материалов главной страницы',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Скачать шаблоны сомов',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Скачать онлайн шаблоны подарочных карт',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Пользователи с правами администратора',
                'is_active' => false
            ],
            'children' => [
                [
                    'menu' => [
                        'name' => 'Новый сотрудник TBUY',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Список всех сотрудников по отделам',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Уведомления для администраторов',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Анализ деятельности сотрудников',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Настройки уведомлений о рисках',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Это внутренний форум',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Аналитика эффективности сотрудников',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Аналитика модерации',
                        'is_active' => false
                    ],
                    'children' => []
                ],
                [
                    'menu' => [
                        'name' => 'Аналитика ввода и вывода системы',
                        'is_active' => false
                    ],
                    'children' => []
                ]
            ]
        ],
        [
            'menu' => [
                'name' => 'Тендеры',
                'is_active' => false
            ],
            'children' => []
        ],
        [
            'menu' => [
                'name' => 'Аукционы',
                'is_active' => false
            ],
            'children' => []
        ],
        [
            'menu' => [
                'name' => 'Недвижимость',
                'is_active' => false
            ],
            'children' => []
        ],
        [
            'menu' => [
                'name' => 'Упаковка',
                'is_active' => false
            ],
            'children' => []
        ]
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /** @var Menu $tariff */
        $tariff = Menu::query()->create([
            'name' => 'Тарифы',
            'slug' => '/tariffs',
            'is_active' => true
        ]);

        $tariff->children()->createMany([
            [
                'name' => 'Список',
                'slug' => '/list',
                'menu_id' => $tariff->id,
                'is_active' => true
            ],
            [
                'name' => 'Создать',
                'slug' => '/new',
                'menu_id' => $tariff->id,
                'is_active' => true,
            ],
            [
                'name' => 'Логи',
                'slug' => '/logs',
                'menu_id' => $tariff->id,
                'is_active' => true
            ]
        ]);

        $this->createMenu($this->menus);
    }

    private function createMenu(array $menus, ?int $menu_id = null): void
    {
        foreach ($menus as $menu) {
            $menu['menu']['menu_id'] = $menu_id;
            $menu['menu']['slug'] = $menu['menu']['name'];

            /** @var Menu $menuModel */
            $menuModel = Menu::query()->create($menu['menu']);

            if (isset($menu['children']) && is_array($menu['children'])) {
                $this->createMenu($menu['children'], $menuModel->id);
            }
        }
    }
}
