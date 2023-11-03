<?php

namespace App\Tbuy\Banner\Repositories;

use App\Tbuy\Banner\DTOs\BannerDTO;
use App\Tbuy\Banner\Models\Banner;
use Illuminate\Database\Eloquent\Collection;

class BannerRepositoryImplementation implements BannerRepository
{
    public function get(): Collection
    {
        return Banner::query()->get();
    }

    public function create(BannerDTO $payload): Banner
    {
        $banner = new Banner($payload->toArray());
        $banner->save();

        return $banner;
    }

    public function update(Banner $banner, BannerDTO $payload): Banner
    {
        $banner->fill($payload->toArray());
        $banner->save();

        return $banner;
    }

    public function delete(Banner $banner): bool
    {
        return $banner->delete();
    }
}
