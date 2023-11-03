<?php

namespace Database\Seeders;

use App\Tbuy\Tariff\DTOs\PriceDTO;
use App\Tbuy\Tariff\Models\Tariff;
use Illuminate\Database\Seeder;

class TariffSeeder extends Seeder
{
    protected array $privileges = [
        [
            'name' => [
                'ru' => 'Известно, что читатель, читая понятный текст',
                'en' => 'It is known that the reader, reading an understandable text',
                'hy' => 'Հայտնի է, որ ընթերցողը, կարդալով հասկանալի տեքստ'
            ]
        ],
        [
            'name' => [
                'ru' => 'Много компьютерной печати',
                'en' => 'A lot of computer printing',
                'hy' => 'Շատ համակարգչային տպագրություն'
            ]
        ],
        [
            'name' => [
                'ru' => 'Вопреки общему мнению',
                'en' => 'Contrary to popular belief',
                'hy' => 'Հակառակ տարածված կարծիքի'
            ]
        ],
    ];

    public function run(): void
    {
        Tariff::query()->create([
            'name' => [
                'ru' => 'Стандарт',
                'en' => 'Standard',
                'hy' => 'Ստանդարտ'
            ],
            'description' => [
                'ru' => 'Цена услуг по настоящему договору составляет 10% от проданного Агентом товара, если проданный товар',
                'en' => 'The price of the services under this contract is 10% of the product sold by the Agent, if the sold product',
                'hy' => 'Սույն պայմանագրով նախատեսված ծառայությունների արժեքը Գործակալի կողմից վաճառված ապրանքի 10%-ն է, եթե վաճառված ապրանքը'
            ],
            'price' => collect([
                new PriceDTO(
                    price: 0,
                    discount_price: null,
                    months: 1
                )
            ]),
            'score' => mt_rand(1, 100),
            'percent' => mt_rand() / mt_getrandmax()
        ])->privileges()->createMany($this->privileges);

        Tariff::query()->create([
            'name' => [
                'ru' => 'Классический',
                'en' => 'Classic',
                'hy' => 'Դասական'
            ],
            'description' => [
                'ru' => 'Цена услуг по настоящему договору составляет 10% от проданного Агентом товара, если проданный товар',
                'en' => 'The price of the services under this contract is 10% of the product sold by the Agent, if the sold product',
                'hy' => 'Սույն պայմանագրով նախատեսված ծառայությունների արժեքը Գործակալի կողմից վաճառված ապրանքի 10%-ն է, եթե վաճառված ապրանքը'
            ],
            'price' => collect([
                new PriceDTO(
                    price: 40_000,
                    discount_price: null,
                    months: 1
                ),
                new PriceDTO(
                    price: 240_000,
                    discount_price: 220_000,
                    months: 6
                ),
                new PriceDTO(
                    price: 820_000,
                    discount_price: 460_000,
                    months: 12
                )
            ]),
            'score' => mt_rand(1, 100),
            'percent' => mt_rand() / mt_getrandmax()
        ])->privileges()->createMany($this->privileges);

        Tariff::query()->create([
            'name' => [
                'ru' => 'Бизнес',
                'en' => 'Business',
                'hy' => 'Բիզնես'
            ],
            'description' => [
                'ru' => 'Цена услуг по настоящему договору составляет 10% от проданного Агентом товара, если проданный товар',
                'en' => 'The price of the services under this contract is 10% of the product sold by the Agent, if the sold product',
                'hy' => 'Սույն պայմանագրով նախատեսված ծառայությունների արժեքը Գործակալի կողմից վաճառված ապրանքի 10%-ն է, եթե վաճառված ապրանքը'
            ],
            'price' => collect([
                new PriceDTO(
                    price: 40_000,
                    discount_price: null,
                    months: 1
                ),
                new PriceDTO(
                    price: 240_000,
                    discount_price: 220_000,
                    months: 6
                ),
                new PriceDTO(
                    price: 820_000,
                    discount_price: 460_000,
                    months: 12
                )
            ]),
            'score' => mt_rand(1, 100),
            'percent' => mt_rand() / mt_getrandmax()
        ])->privileges()->createMany($this->privileges);

        Tariff::query()->create([
            'name' => [
                'ru' => 'Премиум',
                'en' => 'Premium',
                'hy' => 'Հավելավճար'
            ],
            'description' => [
                'ru' => 'Цена услуг по настоящему договору составляет 10% от проданного Агентом товара, если проданный товар',
                'en' => 'The price of the services under this contract is 10% of the product sold by the Agent, if the sold product',
                'hy' => 'Սույն պայմանագրով նախատեսված ծառայությունների արժեքը Գործակալի կողմից վաճառված ապրանքի 10%-ն է, եթե վաճառված ապրանքը'
            ],
            'price' => collect([
                new PriceDTO(
                    price: 40_000,
                    discount_price: null,
                    months: 1
                ),
                new PriceDTO(
                    price: 240_000,
                    discount_price: 220_000,
                    months: 6
                ),
                new PriceDTO(
                    price: 820_000,
                    discount_price: 460_000,
                    months: 12
                )
            ]),
            'score' => mt_rand(1, 100),
            'percent' => mt_rand() / mt_getrandmax()
        ])->privileges()->createMany($this->privileges);
    }
}
