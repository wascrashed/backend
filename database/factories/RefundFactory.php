<?php

namespace Database\Factories;

use App\Tbuy\Refund\Enums\RefundStatus;
use App\Tbuy\Refund\Models\Refund;
use App\Tbuy\Company\Models\Company;
use App\Tbuy\Product\Models\Product;
use App\Tbuy\Brand\Models\Brand;
use App\Tbuy\Purchase\Models\Purchase;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Refund>
 */
class RefundFactory extends Factory
{
    protected $model = Refund::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = Product::query()->inRandomOrder()->first();
        $purchase = Purchase::query()->inRandomOrder()->first();
        $company = Company::query()->inRandomOrder()->first();
        $brand = Brand::query()->inRandomOrder()->first();

        return [
            'status' => $this->faker->randomElement(RefundStatus::cases())->value,
            'product_id' => $product->id,
            'purchase_id' => $purchase->id,
            'company_id' => $company->id,
            'brand_id' => $brand->id,
            'count' =>  $this->faker->randomElement([$this->faker->randomDigit(), 0]),
            'price' =>  $this->faker->randomFloat(),
        ];
    }
}
