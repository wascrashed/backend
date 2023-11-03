<?php

namespace App\Tbuy\Company\SearchRatingCalculations;

use App\Contracts\SearchRatingCalculationContract;
use App\Tbuy\Company\Enums\CompanyType;
use App\Tbuy\Company\Enums\RatingRatio;
use App\Tbuy\Company\Models\Company;
use App\Tbuy\Product\Models\Product;
use Illuminate\Database\Eloquent\Model;

class ProductsImagesDivisionOnProducts implements SearchRatingCalculationContract
{

    public function calculate(Model $model): float|int
    {
        /** @var Company $model */
        $model = $model->load('products.images');
        $division = $this->getProductsImagesDivisionOnProducts($model);


        return $model->legal_entity
            ? (
            $model->type->isServices()
                ? RatingRatio::PRODUCT_IMAGES_DIVISION_ON_PRODUCTS_SERVICE->calculate($division)
                : RatingRatio::PRODUCT_IMAGES_DIVISION_ON_PRODUCTS_SALES->calculate($division)
            )
            : RatingRatio::PRODUCT_IMAGES_DIVISION_ON_PRODUCTS->calculate($division);
    }

    private function getProductsImagesDivisionOnProducts(Company $model): float|int
    {
        $images_count = $this->getImagesCount($model);
        $products_count = $this->getProductsCount($model);


        return $products_count ? $images_count / $products_count : 0;
    }

    private function getImagesCount(Company $company): int
    {
        return $company->products->reduce(function ($result, Product $product) {
            return $result + $product->images->count();
        }, 0);
    }

    private function getProductsCount(Company $company): int
    {
        return $company->products->count();
    }
}
