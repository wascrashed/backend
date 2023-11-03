<?php

namespace Database\Factories;

use App\Tbuy\Audience\Models\Audience;
use App\Tbuy\Brand\Models\Brand;
use App\Tbuy\Company\Models\Company;
use App\Tbuy\Product\Models\Product;
use App\Tbuy\Target\Enums\Status;
use App\Tbuy\Target\Models\Target;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TargetFactory extends Factory
{
    protected $model = Target::class;

    public function definition(): array
    {
        $targetable = [
            Product::query()->inRandomOrder()->first(),
            Brand::query()->inRandomOrder()->first(),
            Company::query()->inRandomOrder()->first()
        ][mt_rand(0, 2)];
        $audience = Audience::query()->inRandomOrder()->first();

        return [
            'audience_id' => $audience->id,
            'targetable_type' => $targetable::class,
            'targetable_id' => $targetable->id,
            'name' => $this->faker->name(),
            'link' => $this->faker->url(),
            'duration' => mt_rand(-30, -1),
            'status' => $this->faker->randomElement(Status::cases())->value,
            'views' => $this->faker->randomNumber(),
            'started_at' => Carbon::now(),
            'finished_at' => Carbon::now(),
        ];
    }
}
