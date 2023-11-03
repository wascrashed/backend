<?php

namespace App\Tbuy\ModelInfo\Resources;

use App\Tbuy\ModelInfo\Models\ModelField;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read ModelField $resource
 */
class ModelFieldResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'slug' => $this->resource->slug,
            'model_list' => ModelListResource::make($this->whenLoaded('model')),
        ];
    }
}
