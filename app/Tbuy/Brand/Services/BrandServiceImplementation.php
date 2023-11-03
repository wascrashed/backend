<?php

namespace App\Tbuy\Brand\Services;

use App\Tbuy\Attributable\Services\AttributableService;
use App\Tbuy\Brand\DTOs\BrandAttachProductDTO;
use App\Tbuy\Brand\DTOs\BrandCategoryDTO;
use App\Tbuy\Brand\DTOs\BrandDTO;
use App\Tbuy\Brand\DTOs\BrandFetchDTO;
use App\Tbuy\Brand\DTOs\BrandStatusDTO;
use App\Tbuy\Brand\Enums\CacheKey;
use App\Tbuy\Brand\Events\AttachProduct;
use App\Tbuy\Brand\Events\BrandRejected;
use App\Tbuy\Brand\Models\Brand;
use App\Tbuy\Brand\Repositories\BrandRepository;
use App\Tbuy\MediaLibrary\Enums\MediaLibraryCollection;
use App\Tbuy\MediaLibrary\Repositories\MediaLibraryRepository;
use App\Traits\HasSubscribers;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as CollectionAlias;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class BrandServiceImplementation implements BrandService
{
    use HasSubscribers;

    public function __construct(
        protected readonly AttributableService  $attributableService,
        private readonly BrandRepository        $brandRepository,
        private readonly MediaLibraryRepository $libraryRepository
    )
    {
    }

    public function get(BrandFetchDTO $parameters): Collection
    {
        return Cache::tags(CacheKey::BRAND_TAG->value)
            ->remember(CacheKey::BRAND_LIST->setKeys($parameters), CacheKey::ttl(), function () use ($parameters) {
                return $this->brandRepository->get($parameters);
            });
    }

    public function create(BrandDTO $payload): Brand
    {
        $brand = DB::transaction(function () use ($payload) {
            $brand = $this->brandRepository->create($payload);

            $this->libraryRepository->addMedia($brand, $payload->logo, MediaLibraryCollection::BRAND_LOGO);
            $this->libraryRepository->addMedia($brand, $payload->certificate, MedialibraryCollection::BRAND_CERTIFICATE);
            return $brand->load(['country', 'company']);
        });

        Cache::tags(CacheKey::BRAND_TAG->value)->clear();

        return $brand;
    }

    public function update(Brand $brand, BrandDTO $payload): Brand
    {
        $brand = DB::transaction(function () use ($brand, $payload) {
            $brand = $this->brandRepository->update($brand, $payload);

            if ($payload->logo) {
                $this->libraryRepository->delete($brand, MediaLibraryCollection::BRAND_LOGO);
                $this->libraryRepository->addMedia($brand, $payload->logo, MediaLibraryCollection::BRAND_LOGO);
            }

            if ($payload->certificate) {
                $this->libraryRepository->delete($brand, MediaLibraryCollection::BRAND_CERTIFICATE);
                $this->libraryRepository->addMedia($brand, $payload->certificate, MediaLibraryCollection::BRAND_CERTIFICATE);
            }


            return $brand->load(['country', 'company']);
        });

        Cache::tags(CacheKey::BRAND_TAG->value)->clear();

        return $brand;
    }

    public function delete(Brand $brand): bool
    {
        $result = $this->brandRepository->delete($brand);

        if ($result) {
            Cache::tags(CacheKey::BRAND_TAG->value)->clear();
        }

        return $result;
    }

    public function setStatus(Brand $brand, BrandStatusDTO $payload, int $userId): Brand
    {
        $brand = $this->brandRepository->changeStatus($brand, $payload);

        if ($payload->status->isRejected()) {
            event(new BrandRejected($brand->id, $payload, $userId));
        }

        Cache::tags(CacheKey::BRAND_TAG->value)->clear();

        return $brand;
    }

    public function attachProducts(Brand $brand, BrandAttachProductDTO $payload): void
    {
        event(new AttachProduct($brand->id, $payload));
    }

    public function setAttribute(Brand $brand, CollectionAlias $collection): Brand
    {
        /** @var Brand $brand */
        $brand = $this->attributableService->prepareAndCreate($brand, $collection);

        Cache::forget(CacheKey::BRAND_LIST->value);

        return $brand;
    }

    public function setCategory(Brand $brand, BrandCategoryDTO $payload): Brand
    {
        $brand = $this->brandRepository->setCategory($brand, $payload);

        Cache::tags(CacheKey::BRAND_TAG->value)->clear();

        return $brand;
    }

    public function extendName(Brand $brand, CollectionAlias $collection): Brand
    {
        /** @var Brand $brand */
        $brand = $this->attributableService->prepareAndSetIsNameTrue($brand, $collection);
        Cache::tags(CacheKey::BRAND_TAG->value)->clear();
        return $brand;
    }
}
