<?php

namespace App\Tbuy\Brand\Resources;

use App\Tbuy\Attributable\Resources\AttributableResource;
use App\Tbuy\Brand\Models\Brand;
use App\Tbuy\Category\Resources\CategoryResource;
use App\Tbuy\Company\Resources\CompanyResource;
use App\Tbuy\Country\Resources\CountryResource;
use App\Tbuy\Product\Resources\ProductResource;
use App\Tbuy\Rejection\Resources\RejectionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Brand $resource
 */
class BrandResource extends JsonResource
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
            'name_extended' => $this->resource->extended_name,
            'date' => $this->resource->date->toDateString(),
            'description' => $this->resource->description,
            'company' => CompanyResource::make($this->whenLoaded('company')),
            'country' => CountryResource::make($this->whenLoaded('country')),
            'products' => ProductResource::collection($this->whenLoaded('products')),
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'attributes' => AttributableResource::collection($this->whenLoaded('attributesList')),
            'rejections' => RejectionResource::collection($this->whenLoaded('rejections')),
            'logo' => $this->resource->logo?->getUrl(),
            'status' => $this->resource->status->value,
            'created_at' => $this->resource->created_at,
            'accepted_at' => $this->resource->accepted_at
        ];
    }
}
