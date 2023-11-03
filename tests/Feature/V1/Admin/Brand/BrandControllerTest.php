<?php

namespace Tests\Feature\V1\Admin\Brand;

use App\Enums\MorphType;
use App\Tbuy\Attributable\DTOs\AttributableDTO;
use App\Tbuy\Attributable\Models\Attributable;
use App\Tbuy\Attribute\Models\Attribute;
use App\Tbuy\Brand\Enums\BrandStatus;
use App\Tbuy\Brand\Models\Brand;
use App\Tbuy\Brand\Services\BrandService;
use App\Tbuy\Category\Models\Category;
use App\Tbuy\Company\Models\Company;
use App\Tbuy\Reason\Models\Reason;
use App\Tbuy\User\Constants\Permission;
use App\Tbuy\User\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class BrandControllerTest extends TestCase
{
    public function test_successfully_create_new_brand()
    {
        /** @var User $user */
        $user = User::query()->first();

        $payload = Brand::factory()->raw([
            'status' => BrandStatus::PENDING->value,
            'certificate' => UploadedFile::fake()->create("fake.pdf"),
            'logo' => UploadedFile::fake()->create('brand_logo.jpg')
        ]);


        $this->actingAs($user)
            ->postJson(
                uri: route('api.v1.admin.brand.store'),
                data: $payload
            )
            ->assertCreated()
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'name',
                    'name_extended',
                    'date',
                    'description',
                    'company' => [
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
                        'documents'
                    ],
                    'country' => [
                        'id',
                        'name',
                        'code'
                    ],
                    'logo',
                    'status',
                    'created_at'
                ]
            ])
            ->assertJson(
                fn(AssertableJson $json) => $json
                    ->where('success', true)
                    ->where('data.status', BrandStatus::PENDING->value)
                    ->etc()
            );

        $this->assertDatabaseHas('brands', [
            'status' => BrandStatus::PENDING->value,
            'company_id' => $payload['company_id'],
            'country_id' => $payload['country_id'],
            'date' => $payload['date']
        ]);
    }

    public function test_fail_validation_error_with_empty_payload()
    {
        /** @var User $user */
        $user = User::query()->first();

        $payload = [];

        $this->actingAs($user)->postJson(
            uri: route('api.v1.admin.brand.store'),
            data: $payload
        )
            ->assertUnprocessable()
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'name.ru',
                    'name.en',
                    'name.hy',
                    'description.ru',
                    'description.en',
                    'description.hy',
                    'country_id',
                    'company_id',
                    'date',
                    'logo'
                ]
            ]);
    }

    public function test_fail_validation_with_wrong_file_type()
    {
        /** @var User $user */
        $user = User::query()->first();

        $payload = Brand::factory()->raw();
        $payload['logo'] = UploadedFile::fake()->create('brand_logo.mp4');

        $this->actingAs($user)
            ->postJson(
                uri: route('api.v1.admin.brand.store'),
                data: $payload
            )
            ->assertUnprocessable()
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'logo'
                ]
            ]);
    }

    public function test_fail_validation_with_wrong_file_size()
    {
        /** @var User $user */
        $user = User::query()->first();

        $payload = Brand::factory()->raw();
        $payload['logo'] = UploadedFile::fake()->create('brand_logo.jpg', (10 * 1024 + 1));

        $this->actingAs($user)
            ->postJson(
                uri: route('api.v1.admin.brand.store'),
                data: $payload
            )
            ->assertUnprocessable()
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'logo'
                ]
            ]);
    }

    public function test_successfully_update()
    {
        /** @var User $user */
        $user = User::query()->first();
        $brand_id = Brand::query()->inRandomOrder()->value('id');
        $payload = Brand::factory()->raw();

        $this->actingAs($user)
            ->putJson(
                uri: route('api.v1.admin.brand.update', $brand_id),
                data: $payload
            )->assertOk()
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'name',
                    'name_extended',
                    'date',
                    'description',
                    'company' => [
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
                        'documents'
                    ],
                    'country' => [
                        'id',
                        'name',
                        'code'
                    ],
                    'logo',
                    'status',
                    'created_at'
                ]
            ])->assertJson(
                fn(AssertableJson $json) => $json
                    ->where('success', true)
                    ->where('data.id', $brand_id)
                    ->where('data.name', $payload['name']['ru'])
                    ->etc()
            );
    }

    public function test_fail_update_with_empty_parameters()
    {
        /** @var User $user */
        $user = User::query()->first();
        $brand_id = Brand::query()->inRandomOrder()->value('id');
        $payload = [];

        $this->actingAs($user)
            ->putJson(
                uri: route('api.v1.admin.brand.update', $brand_id),
                data: $payload
            )->assertUnprocessable()
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'name.ru',
                    'name.en',
                    'name.hy',
                    'description.ru',
                    'description.en',
                    'description.hy',
                    'country_id',
                    'company_id',
                    'date'
                ]
            ]);
    }

    public function test_fail_update_validation_with_wrong_file_type()
    {
        /** @var User $user */
        $user = User::query()->first();
        $brand_id = Brand::query()->inRandomOrder()->value('id');

        $payload = Brand::factory()->raw();
        $payload['logo'] = UploadedFile::fake()->create('brand_logo.mp4');

        $this->actingAs($user)
            ->putJson(
                uri: route('api.v1.admin.brand.update', $brand_id),
                data: $payload
            )
            ->assertUnprocessable()
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'logo'
                ]
            ]);
    }

    public function test_fail_update_validation_with_wrong_file_size()
    {
        /** @var User $user */
        $user = User::query()->first();
        $brand_id = Brand::query()->inRandomOrder()->value('id');

        $payload = Brand::factory()->raw();
        $payload['logo'] = UploadedFile::fake()->create('brand_logo.jpg', (10 * 1024 + 1));

        $this->actingAs($user)
            ->putJson(
                uri: route('api.v1.admin.brand.update', $brand_id),
                data: $payload
            )
            ->assertUnprocessable()
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'logo'
                ]
            ]);
    }

    public function test_successfully_set_status()
    {
        /** @var User $user */
        $user = User::query()->first();

        $brand_id = Brand::query()
            ->inRandomOrder()
            ->where('status', '<>', BrandStatus::ACCEPTED->value)
            ->value('id');

        $payload = [
            'status' => BrandStatus::ACCEPTED->value
        ];

        $this->actingAs($user)
            ->patchJson(
                uri: route('api.v1.admin.brand.set_status', $brand_id),
                data: $payload
            )->assertOk()
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'name',
                    'name_extended',
                    'date',
                    'description',
                    'logo',
                    'status',
                    'created_at'
                ],
            ])->assertJson(
                fn(AssertableJson $json) => $json
                    ->where('success', true)
                    ->where('data.status', BrandStatus::ACCEPTED->value)
                    ->etc()
            );
    }

    public function test_successfully_set_rejected_status()
    {
        /** @var User $user */
        $user = User::query()->first();

        $brand_id = Brand::query()
            ->inRandomOrder()
            ->where('status', '<>', BrandStatus::REJECTED->value)
            ->value('id');

        $payload = [
            'status' => BrandStatus::REJECTED->value,
            'reason_id' => $reason_id = Reason::query()->inRandomOrder()->value('id')
        ];

        $this->actingAs($user)
            ->patchJson(
                uri: route('api.v1.admin.brand.set_status', $brand_id),
                data: $payload
            )
            ->assertOk()
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'name',
                    'name_extended',
                    'date',
                    'description',
                    'logo',
                    'status',
                    'created_at'
                ],
            ])->assertJson(
                fn(AssertableJson $json) => $json
                    ->where('success', true)
                    ->where('data.status', BrandStatus::REJECTED->value)
                    ->etc()
            );

        //TODO test event
//        $this->assertDatabaseHas('rejections', [
//            'rejectionable_type' => MorphType::getType(Brand::class),
//            'rejectionable_id' => $brand_id,
//            'reason_id' => $reason_id,
//            'user_id' => $user->id
//        ]);
    }

    public function test_fail_set_status_with_empty_parameters()
    {
        /** @var User $user */
        $user = User::query()->first();

        $brand_id = Brand::query()
            ->inRandomOrder()
            ->where('status', '<>', BrandStatus::ACCEPTED->value)
            ->value('id');

        $payload = [];

        $this->actingAs($user)
            ->patchJson(
                uri: route('api.v1.admin.brand.set_status', $brand_id),
                data: $payload
            )->assertUnprocessable()
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'status'
                ]
            ]);
    }

    public function test_fail_set_status_with_wrong_status()
    {
        /** @var User $user */
        $user = User::query()->first();

        $brand_id = Brand::query()
            ->inRandomOrder()
            ->where('status', '<>', BrandStatus::ACCEPTED->value)
            ->value('id');

        $payload = [
            'status' => 'som-status'
        ];

        $this->actingAs($user)
            ->patchJson(
                uri: route('api.v1.admin.brand.set_status', $brand_id),
                data: $payload
            )->assertUnprocessable()
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'status'
                ]
            ]);
    }

    public function test_fail_set_rejected_status_without_reason_id()
    {
        /** @var User $user */
        $user = User::query()->first();

        $brand_id = Brand::query()
            ->inRandomOrder()
            ->where('status', '<>', BrandStatus::REJECTED->value)
            ->value('id');

        $payload = [
            'status' => BrandStatus::REJECTED->value
        ];

        $this->actingAs($user)
            ->patchJson(
                uri: route('api.v1.admin.brand.set_status', $brand_id),
                data: $payload
            )->assertUnprocessable()
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'reason_id'
                ]
            ]);
    }

    public function test_successfully_extend_brand_name()
    {
        /** @var User $user */
        $user = User::query()->first();

        /** @var Brand $brand */
        $brand = Brand::query()
            ->inRandomOrder()
            ->first();

        $this->setAttributes($brand);

        $attributes = Attributable::query()
            ->inRandomOrder()
            ->limit(3)
            ->where('attributable_type', '=', MorphType::getType(Brand::class))
            ->where('attributable_id', '=', $brand->id)
            ->get('attribute_id')
            ->pluck('attribute_id')
            ->map(
                fn(int $id) => [
                    'attribute_id' => $id,
                    'is_name_part' => (bool)mt_rand(0, 1)
                ]
            );

        $payload = [
            'attributes' => $attributes->toArray()
        ];

        $this->actingAs($user)
            ->patchJson(
                uri: route('api.v1.admin.brand.extend_name', $brand->id),
                data: $payload
            )->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'name',
                    'name_extended',
                    'date',
                    'description',
                    'attributes' => [
                        [
                            'id',
                            'name',
                            'value' => [
                                'id',
                                'name'
                            ],
                            'is_name_part'
                        ]
                    ],
                    'logo',
                    'status',
                    'created_at'
                ]
            ])->assertJson(
                fn(AssertableJson $json) => $json
                    ->where('success', true)
                    ->where('data.id', $brand->id)
                    ->where('data.name_extended', function (string $name_extended) use ($brand) {
                        $brand = $brand->load('attributesList');
                        $value = $brand->attributesList
                            ->where('is_name_part', true)
                            ->implode('value.name', ' ');
                        return $name_extended === trim($brand->name . " " . $value);
                    })
                    ->etc()
            );
    }

    public function test_fail_extend_name_with_empty_parameters()
    {
        /** @var User $user */
        $user = User::query()->first();

        /** @var Brand $brand */
        $brand = Brand::query()
            ->inRandomOrder()
            ->first();

        $payload = [];

        $this->actingAs($user)
            ->patchJson(
                uri: route('api.v1.admin.brand.extend_name', $brand->id),
                data: $payload
            )->assertUnprocessable()
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'attributes'
                ]
            ]);
    }

    public function test_fail_extend_name_with_empty_attributes()
    {
        /** @var User $user */
        $user = User::query()->first();

        /** @var Brand $brand */
        $brand = Brand::query()
            ->inRandomOrder()
            ->first();

        $payload = [
            'attributes' => []
        ];

        $this->actingAs($user)
            ->patchJson(
                uri: route('api.v1.admin.brand.extend_name', $brand->id),
                data: $payload
            )->assertUnprocessable()
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'attributes'
                ]
            ]);
    }

    public function test_successfully_set_category()
    {
        /** @var User $user */
        $user = User::query()->first();
        $brand_id = Brand::query()->inRandomOrder()->value('id');
        $categories = Category::query()
            ->inRandomOrder()
            ->limit(3)
            ->get('id')
            ->pluck('id');

        $payload = [
            'category' => $categories->toArray()
        ];

        $this->actingAs($user)
            ->postJson(
                uri: route('api.v1.admin.brand.set_category', $brand_id),
                data: $payload
            )->assertCreated()
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'name',
                    'name_extended',
                    'date',
                    'description',
                    'categories' => [
                        [
                            'id',
                            'name',
                            'slug'
                        ]
                    ],
                    'logo',
                    'status',
                    'created_at'
                ]
            ])->assertJson(
                fn(AssertableJson $json) => $json
                    ->where('success', true)
                    ->whereContains('data.categories',
                        fn(array $category) => $categories->where('id', $category['id'])
                    )
                    ->etc()
            );
    }

    public function test_fail_set_category_with_empty_parameters()
    {
        /** @var User $user */
        $user = User::query()->first();
        $brand_id = Brand::query()->inRandomOrder()->value('id');

        $payload = [];

        $this->actingAs($user)
            ->postJson(
                uri: route('api.v1.admin.brand.set_category', $brand_id),
                data: $payload
            )->assertUnprocessable()
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'category'
                ]
            ]);
    }

    public function test_fail_set_category_with_not_existing_category_ids()
    {
        /** @var User $user */
        $user = User::query()->first();
        $brand_id = Brand::query()->inRandomOrder()->value('id');
        $category_id = Category::query()
            ->latest('id')
            ->value('id');

        $payload = [
            'category' => [$category_id + 1000000]
        ];

        $this->actingAs($user)
            ->postJson(
                uri: route('api.v1.admin.brand.set_category', $brand_id),
                data: $payload
            )->assertUnprocessable()
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'category.0'
                ]
            ]);
    }

    public function test_successfully_delete()
    {
        // todo realize brand delete logic

        $this->assertTrue(true);

    }

    private function setAttributes(Brand $brand): void
    {
        $attributes = Attribute::query()
            ->inRandomOrder()
            ->has('values')
            ->with('values')
            ->get()
            ->map(
                fn(Attribute $attribute) => new AttributableDTO(
                    attribute_id: $attribute->id,
                    attribute_value_id: $attribute->values->shuffle()->first()->id,
                    is_name_part: false
                )
            );


        /** @var BrandService $brandService */
        $brandService = app(BrandService::class);
        $brandService->setAttribute($brand, $attributes);
    }

    public function test_update_brand_with_certificate()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $user->givePermissionTo(Permission::UPDATE_BRAND->value);

        $brandData = Brand::factory()->raw([
            'logo' => UploadedFile::fake()->create('logo.jpg'),
            'certificate' => UploadedFile::fake()->create("fake.pdf")
        ]);

        $brand = Brand::factory()->create();

        $this->actingAs($user)->putJson(route('api.v1.admin.brand.update', $brand->id), $brandData)
            ->assertOk()
            ->assertJsonStructure([
                'success',
                'data' => [
                    'id',
                    'name',
                    'description',
                    'company' => [
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
                        'socials' => [
                            'website',
                            'facebook',
                            'instagram',
                            'youtube',
                            'tiktok',
                            'telegram'
                        ],
                        'documents',
                        'tariff',
                        'tariff_expired_at'
                    ],
                    'country' => [
                        'id',
                        'name',
                        'code'
                    ],
                    'logo',
                    'status',
                    'created_at',
                    'accepted_at',
                ],
            ])
            ->assertJson(
                fn(AssertableJson $json) => $json
                    ->where('success', true)
                    ->where('data.id', $brand->id)
                    ->etc()
            );

        $this->assertDatabaseHas('brands', [
            'id' => $brand->id,
        ]);
    }
}
