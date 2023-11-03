<?php

namespace App\Tbuy\Product\Services;

use App\Tbuy\Attributable\Services\AttributableService;
use App\Tbuy\MediaLibrary\Enums\MediaLibraryCollection;
use App\Tbuy\MediaLibrary\Repositories\MediaLibraryRepository;
use App\Tbuy\Product\DTOs\ProductDTO;
use App\Tbuy\Product\DTOs\ProductToggleStatusDTO;
use App\Tbuy\Product\DTOs\ProductUpdateDTO;
use App\Tbuy\Product\Enums\ProductCacheKey;
use App\Tbuy\Product\Models\Product;
use App\Tbuy\Product\Repositories\ProductRepository;
use App\Tbuy\Rejection\Repository\RejectionRepository;
use App\Tbuy\Visible\Repositories\VisibleRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as CollectionAlias;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ProductServiceImplementation implements ProductService
{
    public function __construct(
        protected readonly AttributableService    $attributableService,
        protected readonly ProductRepository      $productRepository,
        protected readonly MediaLibraryRepository $mediaLibraryRepository,
        protected readonly RejectionRepository    $rejectionRepository,
        protected readonly VisibleRepository      $visibleRepository
    )
    {
    }

    public function get(ProductDTO $productDTO, array $with = []): Collection
    {
        return Cache::tags(ProductCacheKey::LIST->value)
            ->remember(ProductCacheKey::LIST->withProductDtoKeys($productDTO), ProductCacheKey::ttl(),
                function () use ($productDTO, $with) {
                    return $this->productRepository->get($productDTO, $with);
                });
    }

    public function update(ProductUpdateDTO $payload, Product $product): Product
    {
        $product = DB::transaction(function () use ($product, $payload) {
            $product = $this->productRepository->update($payload, $product);


            if ($payload->images) {
                $allImages = $this->mediaLibraryRepository->getMedia($product, MediaLibraryCollection::PRODUCT_MEDIA);

                $newImageFileNames = array_column($payload->images, 'file_name');

                $existingImageFileNames = array_column($allImages->toArray(), 'file_name');

                foreach ($allImages as $image) {
                    if (in_array($image->file_name, $newImageFileNames) && in_array($image->file_name,
                            $existingImageFileNames)) {
                        $this->mediaLibraryRepository->delete($product, MediaLibraryCollection::PRODUCT_MEDIA,
                            $image->file_name);
                    }
                }

                $this->mediaLibraryRepository->addAllMedia($product, $payload->images,
                    MediaLibraryCollection::PRODUCT_MEDIA);
            }

            $product = $this->visibleRepository->create($product, $payload->visible_fields);

            return $product->load(['brand.company', 'images', 'category']);
        });

        Cache::tags(ProductCacheKey::LIST->value)->clear();

        return $product;
    }

    public function toggleStatus(Product $product, ProductToggleStatusDTO $payload): Product
    {
        $product = DB::transaction(function () use ($payload, $product) {
            $product = $this->productRepository->toggleStatus($payload, $product);

            if ($product->status->isRejected()) {
                $this->rejectionRepository->create($product, $payload, auth()->id());
            }

            return $product->load('rejections');
        });

        Cache::tags(ProductCacheKey::LIST->value)->clear();

        return $product;
    }

    public function setAttribute(Product $product, CollectionAlias $collection): Product
    {
        /** @var Product $product */
        $product = $this->attributableService->prepareAndCreate($product, $collection);

        Cache::tags(ProductCacheKey::LIST->value)->clear();

        return $product;
    }

    public function getZeroAmount(ProductDTO $productDTO, array $with = []): Collection
    {
        return Cache::tags(ProductCacheKey::ZERO_LIST->value)
            ->remember(ProductCacheKey::ZERO_LIST->setKeys($productDTO), ProductCacheKey::ttl(),
                function () use ($productDTO, $with) {
                    return $this->productRepository->getZeroAmount($productDTO, $with);
                });
    }

    public function extendName(Product $product, CollectionAlias $collection): Product
    {
        /** @var Product $product */
        $product = $this->attributableService->prepareAndSetIsNameTrue($product, $collection);
        Cache::tags(ProductCacheKey::LIST->value)->clear();
        return $product;
    }


}
