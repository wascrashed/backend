<?php

namespace App\Tbuy\Filial\Resources;

use App\Tbuy\Community\Resources\CommunityResource;
use App\Tbuy\Company\Resources\CompanyResource;
use App\Tbuy\Filial\Models\Filial;
use App\Tbuy\Region\Resources\RegionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Filial $resource
 */
class FilialResource extends JsonResource
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
            'phone' => $this->resource->phone,
            'address' => $this->resource->address,
            'coordinates' => $this->resource->coordinates,
            'schedule' => $this->resource->schedule,
            'is_main' => $this->resource->is_main,
            'company' => CompanyResource::make($this->whenLoaded('company')),
            'community' => CommunityResource::make($this->whenLoaded('community')),
            'region' => RegionResource::make($this->whenLoaded('region')),
        ];
    }
}
