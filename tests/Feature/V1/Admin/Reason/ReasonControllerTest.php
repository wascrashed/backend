<?php

namespace Tests\Feature\V1\Admin\Reason;

use App\Tbuy\Reason\Models\Reason;
use App\Tbuy\User\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ReasonControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_index(): void
    {
        /** @var User $user */
        $user = User::query()->first();

        $response = $this->actingAs($user)->getJson(route('api.v1.admin.reason.index'));

        $reasonCount = Reason::query()->count('id');

        $response->assertSuccessful()
            ->assertJsonStructure([
                "success",
                "message",
                "data" => [
                    [
                        "id",
                        "reason"
                    ]
                ]
            ])
            ->assertJson(
                fn(AssertableJson $json) => $json->where('success', true)->has('data', $reasonCount)->etc()
            );
    }
}
