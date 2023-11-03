<?php

namespace App\Tbuy\Brand\Repositories;

use App\Tbuy\Brand\DTOs\BrandAttachProductDTO;
use App\Tbuy\Brand\DTOs\BrandCategoryDTO;
use App\Tbuy\Brand\DTOs\BrandDTO;
use App\Tbuy\Brand\DTOs\BrandFetchDTO;
use App\Tbuy\Brand\DTOs\BrandStatusDTO;
use App\Tbuy\Brand\Enums\BrandStatus;
use App\Tbuy\Brand\Enums\CacheKey;
use App\Tbuy\Brand\Models\Brand;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class BrandRepositoryImplementation implements BrandRepository
{
    public function get(BrandFetchDTO $parameters): Collection
    {
        return Brand::query()
            ->filterByDate($parameters->date)
            ->filterByReason($parameters->reason_id)
            ->filterByCompany($parameters->company)
            ->filterByCategory($parameters->category)
            ->filterByBrand($parameters->brand_id)
            ->filterByStatus(BrandStatus::tryFrom($parameters->status))
            ->with(['attributesList', 'categories', 'company', 'country', 'logo', 'products'])
            ->get();
    }

    public function findById(int $brand_id): Brand
    {
        /** @var Brand $brand */
        $brand = Brand::query()->findOrFail($brand_id);

        return $brand;
    }

    public function create(BrandDTO $payload): Brand
    {
        $brand = new Brand([
            'date' => $payload->date,
            'company_id' => $payload->company_id,
            'country_id' => $payload->country_id,
            'status' => BrandStatus::PENDING,
        ]);
        $brand = $this->addTranslations($brand, $payload);
        $brand->save();

        return $brand;
    }

    public function update(Brand $brand, BrandDTO $payload): Brand
    {
        $brand->fill([
            'date' => $payload->date,
            'company_id' => $payload->company_id,
            'country_id' => $payload->country_id,
        ]);
        $brand = $this->addTranslations($brand, $payload);
        $brand->save();

        return $brand;
    }

    private function addTranslations(Brand $brand, BrandDTO $payload): Brand
    {
        return $brand->setTranslations('name', $payload->name)
            ->setTranslations('description', $payload->description);
    }

    public function changeStatus(Brand $brand, BrandStatusDTO $payload): Brand
    {
        $brand->fill($payload->toArray());

        if ($payload->status == BrandStatus::ACCEPTED) {
            $brand->accepted_at = now();
        }

        $brand->save();

        return $brand;
    }

    public function delete(Brand $brand): bool
    {
        $brand->load(['products', 'categories']);

        if ($brand->products->count() ||
            $brand->categories->count()) {
            return false;
        }

        Cache::tags(CacheKey::BRAND_TAG)->clear();

        return !!$brand->delete();
    }

    public function attachProducts(Brand $brand, BrandAttachProductDTO $payload): void
    {
        $brand->products()->sync($payload->product);
    }

    public function setCategory(Brand $brand, BrandCategoryDTO $payload): Brand
    {
        $brand->categories()->sync($payload->category);

        return $brand->load('categories');
    }
}
