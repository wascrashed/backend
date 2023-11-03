<?php

namespace App\Tbuy\Search\Resources;

use App\Tbuy\ModelInfo\Resources\ModelListResource;
use App\Tbuy\Search\Model\SearchableModel;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read SearchableModel $resource
 */
class SearchModelResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'model' => ModelListResource::make($this->whenLoaded('modelList')),
            'priority' => $this->resource->priority,
            'count' => $this->resource->count,
        ];
    }
}
