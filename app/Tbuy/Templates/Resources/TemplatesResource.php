<?php

namespace App\Tbuy\Templates\Resources;

use App\Tbuy\Banner\Resources\BannerResource;
use App\Tbuy\Templates\Models\Templates;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Templates $resource
 */
class TemplatesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'banner_id' => BannerResource::make($this->whenLoaded('banner'))
        ];
    }
}
