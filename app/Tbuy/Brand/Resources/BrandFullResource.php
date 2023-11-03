<?php

namespace App\Tbuy\Brand\Resources;

use App\Tbuy\Brand\Models\Brand;
use App\Tbuy\Company\Resources\CompanyResource;
use App\Tbuy\Country\Resources\CountryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Brand $resource
 */
class BrandFullResource extends JsonResource
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
            'name' => $this->resource->getTranslations('name'),
            'date' => $this->resource->date,
            'description' => $this->resource->getTranslations('description'),
            'company' => CompanyResource::make($this->whenLoaded('company')),
            'country' => CountryResource::make($this->whenLoaded('country')),
            'logo' => $this->resource->logo?->getUrl(),
            'status' => $this->resource->status->value
        ];
    }
}
