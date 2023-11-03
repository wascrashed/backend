<?php

namespace App\Tbuy\Templates\Repositories;

use App\Tbuy\Templates\DTOs\TemplatesDTO;
use App\Tbuy\Templates\Models\Templates;
use Illuminate\Database\Eloquent\Collection;

class TemplatesRepositoryImplementation implements TemplatesRepository
{
    public function get(): Collection
    {
        return Templates::all();
    }

    public function create(TemplatesDTO $payload): Templates
    {
        $banner = new Templates([
            'name' => $payload->name,
            'banner_id' => $payload->banner_id
        ]);
        $banner->save();

        return $banner;
    }

    public function update(Templates $banner, TemplatesDTO $payload): Templates
    {
        $banner->fill([
            'name' => $payload->name,
            'banner_id' => $payload->banner_id
        ]);
        $banner->save();

        return $banner;
    }

    public function delete(Templates $banner): void
    {
        $banner->delete();
    }
}


