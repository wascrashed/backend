<?php

namespace App\Tbuy\Attributable\Resources;

use App\Tbuy\Attributable\Models\Attributable;
use App\Tbuy\Attribute\Resources\AttributeResource;
use App\Tbuy\AttributeValue\Resources\AttributeValueResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Attributable $resource
 */
class AttributableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->when('attribute', fn() => $this->resource->attribute->id),
            'name' => $this->when('attribute', fn() => $this->resource->attribute->name),
            'value' => AttributeValueResource::make($this->whenLoaded('value')),
            'is_name_part' => $this->resource->is_name_part
        ];
    }
}
