<?php

namespace App\Tbuy\Brand\Services;

use App\Tbuy\Brand\DTOs\BrandAttachProductDTO;
use App\Tbuy\Brand\DTOs\BrandCategoryDTO;
use App\Tbuy\Brand\DTOs\BrandDTO;
use App\Tbuy\Brand\DTOs\BrandFetchDTO;
use App\Tbuy\Brand\DTOs\BrandStatusDTO;
use App\Tbuy\Brand\Models\Brand;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as CollectionAlias;

interface BrandService
{
    public function get(BrandFetchDTO $parameters): Collection;

    public function create(BrandDTO $payload): Brand;

    public function update(Brand $brand, BrandDTO $payload): Brand;

    public function delete(Brand $brand): bool;

    public function setStatus(Brand $brand, BrandStatusDTO $payload, int $userId): Brand;

    public function attachProducts(Brand $brand, BrandAttachProductDTO $payload): void;

    public function setCategory(Brand $brand, BrandCategoryDTO $payload): Brand;

    public function setAttribute(Brand $brand, CollectionAlias $collection): Brand;

    public function extendName(Brand $brand, CollectionAlias $collection): Brand;
}
