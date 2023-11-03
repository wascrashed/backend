<?php

namespace App\Tbuy\Search\Resources;

use App\Tbuy\ModelInfo\Resources\ModelFieldResource;
use App\Tbuy\Search\Model\SearchableField;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read SearchableField $resource
 */
class SearchFieldResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'model_field' => ModelFieldResource::make($this->whenLoaded('modelField')),
            'searchable_model' => SearchModelResource::make($this->whenLoaded('searchableModel')),
            'priority' => $this->resource->priority,
        ];
    }
}
