<?php

namespace App\Tbuy\Banner\Services;

use App\Tbuy\Banner\DTOs\BannerDTO;
use App\Tbuy\Banner\Models\Banner;
use Illuminate\Database\Eloquent\Collection;

interface BannerService
{
    public function getWithCache(): Collection;

    public function createAndClearCache(BannerDTO $payload): Banner;

    public function updateAndClearCache(Banner $banner, BannerDTO $payload): Banner;

    public function deleteAndClearCache(Banner $banner): bool;
}
