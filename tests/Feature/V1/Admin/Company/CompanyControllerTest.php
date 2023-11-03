<?php

namespace Tests\Feature\V1\Admin\Company;

use App\Enums\MorphType;
use App\Tbuy\Company\Enums\CompanyStatus;
use App\Tbuy\Company\Models\Company;
use App\Tbuy\Reason\Models\Reason;
use App\Tbuy\User\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class CompanyControllerTest extends TestCase
{
    use WithFaker;

    public function test_successfully_get_list(): void
    {
        /** @var User $user */
        $user = User::query()->first();
        $companyCount = Company::query()->count();

        $this->actingAs($user)
            ->getJson(
                uri: route('api.v1.admin.company.index')
            )->assertOk()
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    [
                        'id',
                        'name',
                        'legal_name_company',
                        'description',
                        'inn',
                        'company_address',
                        'phones' => [
                            'phone_director',
                            'phone_sales_department',
                            'phone_marketing_department',
                            'phone_operator',
                            'phone_viber',
                            'phone_whatsapp',
                            'phone_telegram',
                        ],
                        'email',
                        'slug',
                        'legal_entity',
                        'type',
                        'status',
                        'brands' => [
                            [
                                'id',
                                'name',
                                'name_extended',
                                'date',
                                'description',
                                'logo',
                                'status',
                                'created_at',
                                'accepted_at'
                            ]
                        ],
                        'socials' => [
                            'website',
                            'facebook',
                            'instagram',
                            'youtube',
                            'tiktok',
                            'telegram'
                        ],
                        'documents' => [
                            'brand',
                            'inn',
                            'passport',
                            'state_register'
                        ],
                        'average_rating_score'
                    ]
                ]
            ])
            ->assertJson(
                fn(AssertableJson $json) => $json
                    ->where('success', true)
                    ->has('data', $companyCount)
                    ->etc()
            );
    }

    public function test_success_get_list_with_filter_by_status()
    {
        /** @var User $user */
        $user = User::query()->first();
        $companyCount = Company::query()
            ->where('status', '=', CompanyStatus::REJECTED->value)
            ->count();

        $filter = [
            'status' => CompanyStatus::REJECTED->value
        ];

        $response = $this->actingAs($user)
            ->getJson(
                uri: route('api.v1.admin.company.index', $filter)
            )
            ->assertOk()
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'legal_name_company',
                        'description',
                        'inn',
                        'company_address',
                        'phones' => [
                            'phone_director',
                            'phone_sales_department',
                            'phone_marketing_department',
                            'phone_operator',
                            'phone_viber',
                            'phone_whatsapp',
                            'phone_telegram',
                        ],
                        'email',
                        'slug',
                        'legal_entity',
                        'type',
                        'status',
                        'brands' => [
                            [
                                'id',
                                'name',
                                'name_extended',
                                'date',
                                'description',
                                'logo',
                                'status',
                                'created_at',
                                'accepted_at'
                            ]
                        ],
                        'socials' => [
                            'website',
                            'facebook',
                            'instagram',
                            'youtube',
                            'tiktok',
                            'telegram'
                        ],
                        'documents' => [
                            'brand',
                            'inn',
                            'passport',
                            'state_register'
                        ],
                        'average_rating_score',
                        'rejections' => [
                            [
                                'id',
                                'target',
                                'image',
                                'reason' => [
                                    'id',
                                    'reason'
                                ],
                                'created_at'
                            ]
                        ]
                    ]
                ]
            ])
            ->assertJson(
                fn(AssertableJson $json) => $json
                    ->where('success', true)
                    ->has('data', $companyCount)
                    ->etc()
            )->json('data');

        collect($response)->each(
            fn(array $company) => $this->assertEquals(CompanyStatus::REJECTED->value, $company['status'])
        );
    }

    public function test_success_get_list_with_filter_by_parent()
    {
        /** @var User $user */
        $user = User::query()->first();
        $companyCount = Company::query()
            ->whereDoesntHave('parent')
            ->count();

        $filter = [
            'parent' => true
        ];

        $this->actingAs($user)
            ->getJson(
                uri: route('api.v1.admin.company.index', $filter)
            )
            ->assertOk()
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    [
                        'id',
                        'name',
                        'legal_name_company',
                        'description',
                        'inn',
                        'company_address',
                        'phones' => [
                            'phone_director',
                            'phone_sales_department',
                            'phone_marketing_department',
                            'phone_operator',
                            'phone_viber',
                            'phone_whatsapp',
                            'phone_telegram',
                        ],
                        'email',
                        'slug',
                        'legal_entity',
                        'status',
                        'socials' => [
                            'website',
                            'facebook',
                            'instagram',
                            'youtube',
                            'tiktok',
                            'telegram'
                        ],
                        'documents' => [
                            'brand',
                            'inn',
                            'passport',
                            'state_register'
                        ]
                    ]
                ]
            ])
            ->assertJson(
                fn(AssertableJson $json) => $json
                    ->where('success', true)
                    ->has('data', $companyCount)
                    ->etc()
            )->json('data');
    }

    public function test_successfully_create_new_company()
    {
        /** @var User $user */
        $user = User::query()->first();

        $companyPayload = Company::factory()->raw([
            'inn' => (string)mt_rand(10000000, 99999999),
            'brand_document' => UploadedFile::fake()->create('fake_brand_document.pdf', 1024),
            'inn_document' => UploadedFile::fake()->create('fake_inn_document.pdf', 1024),
            'passport_document' => UploadedFile::fake()->create('fake_passport_document.pdf', 1024),
            'state_register_document' => UploadedFile::fake()->create('fake_state_register_document.pdf', 1024),
            'phones' => [
                'phone_director' => $this->faker->phoneNumber,
            ],
        ]);

        $this->actingAs($user)
            ->postJson(
                uri: route('api.v1.admin.company.store'),
                data: $companyPayload
            )
            ->assertCreated()
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'name',
                    'description',
                    'phones' => [
                        'phone_director',
                    ],
                    'email',
                    'slug',
                    'legal_entity',
                    'status',
                    'socials' => [
                        'website',
                        'facebook',
                        'instagram',
                        'youtube',
                        'tiktok',
                        'telegram'
                    ],
                    'documents' => [
                        'brand',
                        'inn',
                        'passport',
                        'state_register'
                    ]
                ]
            ])
            ->assertJson(
                fn(AssertableJson $json) => $json
                    ->where('data.name', $companyPayload['name']['ru'])->etc()
            );
    }

    public function test_fail_creation_validation_without_files()
    {
        /** @var User $user */
        $user = User::query()->first();
        $companyPayload = Company::factory()->raw([
            'inn' => (string)mt_rand(10000000, 99999999),
        ]);

        unset($companyPayload['brand_document']);
        unset($companyPayload['inn_document']);
        unset($companyPayload['passport_document']);
        unset($companyPayload['state_register_document']);

        $this->actingAs($user)
            ->postJson(
                uri: route('api.v1.admin.company.store'),
                data: $companyPayload
            )
            ->assertUnprocessable()
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'brand_document',
                    'inn_document',
                    'passport_document',
                    'state_register_document',
                ],
            ]);
    }

    public function test_fail_creation_validation_without_inputs()
    {
        /** @var User $user */
        $user = User::query()->first();

        $companyPayload = [];

        $this->actingAs($user)
            ->postJson(
                uri: route('api.v1.admin.company.store'),
                data: $companyPayload
            )
            ->assertUnprocessable()
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'name.ru',
                    'name.en',
                    'name.hy',
                    'type',
                    'inn',
                    'director.first_name',
                    'director.last_name',
                    'phones.phone_director',
                    'email',
                    'slug',
                    'legal_entity',
                    'brand_document',
                    'inn_document',
                    'passport_document',
                    'state_register_document',
                ],
            ]);
    }

    public function test_successfully_update()
    {
        /**
         * @var User $user
         * @var Company $company
         */
        $user = User::query()->first();

        $company = Company::query()->inRandomOrder()->first();

        $companyPayload = Company::factory()->raw([
            'description' => [
                'ru' => $this->faker->text,
                'en' => $this->faker->text,
                'hy' => $this->faker->text,
            ],
            'phones' => [
                'phone_director' => $this->faker->phoneNumber,
            ],
            'inn' => (string)mt_rand(10000000, 99999999),
            'brand_document' => UploadedFile::fake()->create('fake_brand_document.pdf', 1024),
            'inn_document' => UploadedFile::fake()->create('fake_inn_document.pdf', 1024),
            'passport_document' => UploadedFile::fake()->create('fake_passport_document.pdf', 1024),
            'state_register_document' => UploadedFile::fake()->create('fake_state_register_document.pdf', 1024),
            'user_id' => $user->id
        ]);

        $this->actingAs($user)
            ->putJson(
                uri: route('api.v1.admin.company.update', $company->id),
                data: $companyPayload
            )
            ->assertOk()
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'name',
                    'legal_name_company',
                    'description',
                    'inn',
                    'company_address',
                    'phones' => [
                        'phone_director',
                        'phone_sales_department',
                        'phone_marketing_department',
                        'phone_operator',
                        'phone_viber',
                        'phone_whatsapp',
                        'phone_telegram',
                    ],
                    'email',
                    'slug',
                    'legal_entity',
                    'status',
                    'socials' => [
                        'website',
                        'facebook',
                        'instagram',
                        'youtube',
                        'tiktok',
                        'telegram'
                    ],
                    'documents' => [
                        'brand',
                        'inn',
                        'passport',
                        'state_register'
                    ]
                ]
            ]);
    }

    public function test_fail_update_validation_without_body_parameters()
    {
        /**
         * @var User $user
         * @var Company $company
         */
        $user = User::query()->first();

        $company = Company::query()->inRandomOrder()->first();

        $companyPayload = [
            'phones' => [
                'phone_director' => '15678900987656784905153498716',
                'phone_sales_department' => '15678900987656784905153498716',
                'phone_marketing_department' => '15678900987656784905153498716',
                'phone_operator' => '15678900987656784905153498716',
                'phone_viber' => '15678900987656784905153498716',
                'phone_whatsapp' => '15678900987656784905153498716',
                'phone_telegram' => '15678900987656784905153498716',
            ],
        ];

        $this->actingAs($user)
            ->putJson(
                uri: route('api.v1.admin.company.update', $company->id),
                data: $companyPayload
            )
            ->assertUnprocessable()
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'name.ru',
                    'name.en',
                    'name.hy',
                    'legal_name_company',
                    'description.ru',
                    'description.en',
                    'description.hy',
                    'company_address',
                    'type',
                    'inn',
                    'director.first_name',
                    'director.last_name',
                    'phones.phone_director',
                    'phones.phone_sales_department',
                    'phones.phone_marketing_department',
                    'phones.phone_operator',
                    'phones.phone_viber',
                    'phones.phone_whatsapp',
                    'phones.phone_telegram',
                    'email',
                    'slug',
                ]
            ]);
    }

    public function test_fail_update_validation_with_wrong_file_types()
    {
        /**
         * @var User $user
         * @var Company $company
         */
        $user = User::query()->first();

        $company = Company::query()->inRandomOrder()->first();

        $companyPayload = Company::factory()->raw([
            'inn' => (string)mt_rand(10000000, 99999999),
            'brand_document' => UploadedFile::fake()->create('fake_brand_document.php', 1024),
            'inn_document' => UploadedFile::fake()->create('fake_inn_document.py', 1024),
            'passport_document' => UploadedFile::fake()->create('fake_passport_document.mp4', 1024),
            'state_register_document' => UploadedFile::fake()->create('fake_state_register_document.pdf', (6 * 1024)),
        ]);

        $this->actingAs($user)
            ->putJson(
                uri: route('api.v1.admin.company.update', $company->id),
                data: $companyPayload
            )
            ->assertUnprocessable()
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'brand_document',
                    'inn_document',
                    'passport_document',
                    'state_register_document'
                ]
            ]);
    }

    public function test_successfully_toggle_status()
    {
        /**
         * @var User $user
         * @var Company $company
         */
        $user = User::query()->first();

        $company = Company::query()
            ->where('status', '<>', CompanyStatus::ACTIVE->value)
            ->inRandomOrder()
            ->first();

        $companyPayload = [
            'status' => CompanyStatus::ACTIVE->value
        ];

        $this->actingAs($user)
            ->patchJson(
                uri: route('api.v1.admin.company.toggle_status', $company->id),
                data: $companyPayload
            )->assertOk()
            ->assertJsonStructure([
                'success',
                'message'
            ])->assertJson(
                fn(AssertableJson $json) => $json
                    ->where('success', true)
                    ->where('message', 'Статус изменен')
                    ->etc()
            );

        $this->assertDatabaseHas($company->getTable(), [
            'id' => $company->id,
            'status' => CompanyStatus::ACTIVE->value
        ]);
    }

    public function test_successfully_set_rejected_status()
    {
        /**
         * @var User $user
         * @var Company $company
         */
        $user = User::query()->first();

        $company = Company::query()
            ->where('status', '<>', CompanyStatus::REJECTED->value)
            ->inRandomOrder()
            ->first();

        $companyPayload = [
            'status' => CompanyStatus::REJECTED->value,
            'reason_id' => $reason_id = Reason::query()->inRandomOrder()->value('id')
        ];

        $this->actingAs($user)
            ->patchJson(
                uri: route('api.v1.admin.company.toggle_status', $company->id),
                data: $companyPayload
            )
            ->assertOk()
            ->assertJsonStructure([
                'success',
                'message'
            ])->assertJson(
                fn(AssertableJson $json) => $json
                    ->where('success', true)
                    ->where('message', 'Статус изменен')
                    ->etc()
            );

        $this->assertDatabaseHas($company->getTable(), [
            'id' => $company->id,
            'status' => CompanyStatus::REJECTED->value
        ])->assertDatabaseHas('rejections', [
            'rejectionable_type' => MorphType::getType(Company::class),
            'rejectionable_id' => $company->id,
            'reason_id' => $reason_id,
            'user_id' => $user->id
        ]);
    }

    public function test_fail_validation_fail_set_rejected_status()
    {
        /** @var User $user */
        $user = User::query()->first();

        $company_id = Company::query()
            ->where('status', '<>', CompanyStatus::REJECTED->value)
            ->inRandomOrder()
            ->value('id');

        $companyPayload = [
            'status' => CompanyStatus::REJECTED->value,
        ];

        $this->actingAs($user)
            ->patchJson(
                uri: route('api.v1.admin.company.toggle_status', $company_id),
                data: $companyPayload
            )
            ->assertUnprocessable()
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'reason_id'
                ]
            ]);
    }

    public function test_fail_validation_wrong_status()
    {
        /** @var User $user */
        $user = User::query()->first();

        $company_id = Company::query()
            ->where('status', '<>', CompanyStatus::REJECTED->value)
            ->inRandomOrder()
            ->value('id');

        $companyPayload = [];

        $this->actingAs($user)
            ->patchJson(
                uri: route('api.v1.admin.company.toggle_status', $company_id),
                data: $companyPayload
            )
            ->assertUnprocessable()
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'status'
                ]
            ]);
    }

    public function test_successfully_destroy()
    {
        // todo Not realised
        $this->assertTrue(true);
    }
}
