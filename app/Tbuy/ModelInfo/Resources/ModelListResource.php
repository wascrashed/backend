<?php

namespace App\Tbuy\ModelInfo\Resources;

use App\Tbuy\ModelInfo\Models\ModelList;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read  ModelList $resource
 */
class ModelListResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'model' => $this->resource->model,
            'label' => $this->resource->label,
        ];
    }
}
