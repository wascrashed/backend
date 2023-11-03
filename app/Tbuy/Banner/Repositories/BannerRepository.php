<?php

namespace App\Tbuy\Banner\Repositories;

use App\Tbuy\Banner\DTOs\BannerDTO;
use App\Tbuy\Banner\Models\Banner;
use Illuminate\Database\Eloquent\Collection;

interface BannerRepository
{
    public function get(): Collection;

    public function create(BannerDTO $payload): Banner;

    public function update(Banner $banner, BannerDTO $payload): Banner;

    public function delete(Banner $banner): bool;
}
