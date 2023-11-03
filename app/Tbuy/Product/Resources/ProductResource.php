<?php

namespace App\Tbuy\Product\Resources;

use App\Tbuy\Attributable\Resources\AttributableResource;
use App\Tbuy\Brand\Resources\BrandResource;
use App\Tbuy\Category\Resources\CategoryResource;
use App\Tbuy\Company\Resources\CompanyResource;
use App\Tbuy\Product\Models\Product;
use App\Tbuy\Rejection\Resources\RejectionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property-read Product $resource
 */
class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'name_extended' => $this->resource->extended_name,
            'description' => $this->resource->description,
            'amount' => $this->resource->amount,
            'type' => $this->resource->type->value,
            'active' => $this->resource->active,
            'color' => $this->resource->color,
            'size' => $this->resource->size,
            'status' => $this->resource->status,
            'price' => $this->resource->price,
            'update_count' => $this->resource->update_count,
            'brand' => BrandResource::make($this->whenLoaded('brand')),
            'category' => CategoryResource::make($this->whenLoaded('category')),
            'images' => $this->resource->images->map(function (?Media $image) {
                return $image?->getUrl();
            })->toArray(),
            'mainImage' => $this->whenLoaded('mainImage', fn() => $this->resource->mainImage?->getUrl()),
            'attributes' => AttributableResource::collection($this->whenLoaded('attributesList')),
            'accepted_at' => $this->resource->accepted_at,
            'created_at' => $this->resource->created_at,
            'rejections' => RejectionResource::collection($this->whenLoaded('rejections')),
            'visible_fields' => $this->whenLoaded('visibleFields', fn() => $this->resource->visibleFields->fields)
        ];
    }
}
