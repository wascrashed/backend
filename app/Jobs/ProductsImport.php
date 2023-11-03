<?php

namespace App\Jobs;

use App\Tbuy\Brand\Enums\BrandStatus;
use App\Tbuy\Brand\Models\Brand;
use App\Tbuy\Product\Enums\ProductStatus;
use App\Tbuy\Product\Enums\ProductType;
use App\Tbuy\Product\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProductsImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected Collection $products
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $brands = collect();
        $date = now()->toDateTimeString();

        $products = $this->products->map(function (object $product) use (&$brands, $date) {
            if (is_null($brand = $brands->where('name', 'LIKE', '%'.$product->product_brand.'%')->first())) {
                $brand = Brand::query()->where('name', 'LIKE', '%'.$product->product_brand.'%')->first();

                if (!$brand) {
                    $brand = Brand::query()->create([
                        'name' => [
                            'ru' => $product->product_brand,
                            'en' => $product->product_brand,
                            'hy' => $product->product_brand
                        ],
                        'company_id' => 1,
                        'country_id' => 1,
                        'date' => $date,
                        'status' => BrandStatus::ACCEPTED,
                    ]);

                    $brands->add($brand);
                }
            }

            return [
                'id' => $product->id,
                'name' => json_encode([
                    'ru' => $product->product_full_name,
                    'en' => $product->product_full_name,
                    'hy' => $product->product_full_name
                ]),
                'description' => json_encode([
                    'ru' => $product->product_description,
                    'en' => $product->product_description,
                    'hy' => $product->product_description
                ]),
                'amount' => 0,
                'price' => $product->praduct_price,
                'type' => ProductType::DEFAULT->value,
                'active' => true,
                'brand_id' => $brand->id,
                'category_id' => $product->product_category,
                'accepted_at' => $date,
                'status' => ProductStatus::CONFIRMED->value,
                'created_at' => $date,
                'updated_at' => $date,
            ];
        })->toArray();

        Product::query()->insert($products);
    }
}
