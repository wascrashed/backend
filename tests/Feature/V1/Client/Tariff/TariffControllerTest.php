<?php

namespace Tests\Feature\V1\Client\Tariff;

use App\Tbuy\Tariff\DTOs\PriceDTO;
use App\Tbuy\Tariff\Models\Tariff;
use App\Tbuy\User\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class TariffControllerTest extends TestCase
{
    public function test_successfully_get_list(): void
    {
        /** @var User $user */
        $user = User::query()->first();

        $tariff_count = Tariff::query()->count();

        $this->actingAs($user)
            ->getJson(
                uri: route('api.v1.client.tariff.index')
            )->assertOk()
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    [
                        'id',
                        'name',
                        'description',
                        'privileges' => [
                            0
                        ],
                        'price' => [
                            [
                                'price',
                                'discount_price',
                                'months'
                            ]
                        ],
                        'score',
                        'percent'
                    ]
                ]
            ])->assertJson(
                fn(AssertableJson $json) => $json
                    ->where('success', true)
                    ->has('data', $tariff_count)
                    ->etc()
            );
    }

    public function test_successfully_buy_tariff()
    {
        /**
         * @var User $user
         * @var Tariff $tariff
         */
        $user = User::query()->first();
        $tariff = Tariff::query()->inRandomOrder()->first();

        /** @var PriceDTO $price */
        $price = $tariff->price->last();

        $user = $this->fillUserBalance($user, $price);

        $payload = [
            'term_month' => $price->months
        ];

        $left_balance = ($user->balance - $this->getPrice($price));

        $this->actingAs($user)
            ->postJson(
                uri: route('api.v1.client.tariff.buy', $tariff->id),
                data: $payload
            )->assertOk()
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'user' => [
                        'id',
                        'name',
                        'email',
                        'balance',
                        'created_at'
                    ]
                ]
            ])->assertJson(
                fn(AssertableJson $json) => $json
                    ->where('success', true)
                    ->where('data.user.balance', (int)$left_balance)
                    ->etc()
            );

        $this->assertDatabaseHas('company_tariff', [
            'company_id' => $user->company->id,
            'tariff_id' => $tariff->id,
            'expired_at' => $expired_at = now()->addMonths($price->months)->endOfDay()
        ])->assertDatabaseHas('tariff_user', [
            'user_id' => $user->id,
            'tariff_id' => $tariff->id,
            'price' => $this->getPrice($price),
            'term_month' => $price->months,
            'expired_at' => $expired_at
        ])->assertDatabaseHas('tariff_logs', [
            'user_id' => $user->id,
            'company_id' => $user->company->id,
            'tariff_id' => $tariff->id,
            'months' => $price->months,
            'price' => $this->getPrice($price)
        ])->assertDatabaseHas('users', [
            'id' => $user->id,
            'balance' => $left_balance
        ]);
    }

    public function test_fail_buy_tariff_with_wrong_month()
    {
        /**
         * @var User $user
         * @var Tariff $tariff
         */
        $user = User::query()->first();
        $tariff = Tariff::query()->inRandomOrder()->first();

        $payload = [
            'term_month' => 111111
        ];

        $this->actingAs($user)
            ->postJson(
                uri: route('api.v1.client.tariff.buy', $tariff->id),
                data: $payload
            )->assertUnprocessable()
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'term_month'
                ]
            ]);
    }

    public function test_fail_buy_tariff_with_low_balance()
    {
        /**
         * @var User $user
         * @var Tariff $tariff
         */
        $user = User::query()->first();
        $tariff = Tariff::query()->inRandomOrder()->first();

        $user->update(['balance' => -1]);

        $payload = [
            'term_month' => $tariff->price->last()->months
        ];

        $this->actingAs($user)
            ->postJson(
                uri: route('api.v1.client.tariff.buy', $tariff->id),
                data: $payload
            )->assertBadRequest()
            ->assertJsonStructure([
                'success',
                'message'
            ])->assertJson(
                fn(AssertableJson $json) => $json
                    ->where('success', false)
                    ->where('message', 'Недостаточно средств')
                    ->etc()
            );
    }

    private function fillUserBalance(User $user, PriceDTO $price): User
    {
        $user->fill([
            'balance' => $user->balance + max($price->discount_price, $price->price)
        ])->save();

        return $user;
    }

    private function getPrice(PriceDTO $price): float
    {
        return $price->discount_price ?: $price->price;
    }
}
