<?php

namespace Tests\Feature\V1\Client\Company;

use App\Tbuy\Company\Models\Company;
use App\Tbuy\User\Models\User;
use Illuminate\Support\Str;
use Tests\TestCase;

class DataConfirmationTest extends TestCase
{
    public function test_response_data_confirmation()
    {
        /** @var Company $company */
        $company = Company::query()->inRandomOrder()->first();

        /** @var User $user */
        $user = User::query()->first();

        $requestData = [
            'bank_account' => Str::random(20),
            'tariff_conditions_accepted_at' => now()->toDateTimeString(),
            'basic_agreement_accepted_at' => now()->toDateTimeString(),
        ];

        $this->actingAs($user)
            ->postJson(
                uri: route('api.v1.client.company.data-confirmation', ['company' => $company->id]),
                data: $requestData
            )
            ->assertStatus(200)
            ->assertJson([
                "message" => "Вы подтвердили компанию"
            ]);
    }

    public function test_validation_for_data_confirmation()
    {
        /** @var Company $company */
        $company = Company::query()->inRandomOrder()->first();

        /** @var User $user */
        $user = User::query()->first();

        $this->actingAs($user)
            ->postJson(
                uri: route('api.v1.client.company.data-confirmation', ['company' => $company->id]),
            )
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'bank_account',
                'tariff_conditions_accepted_at',
                'basic_agreement_accepted_at',
            ]);
    }
}
