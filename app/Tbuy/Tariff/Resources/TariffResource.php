<?php

namespace App\Tbuy\Tariff\Resources;

use App\Tbuy\Tariff\Models\Tariff;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Tariff $resource
 */
class TariffResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'description' => $this->resource->description,
            'privileges' => TariffPrivilegeResource::collection($this->whenLoaded('privileges')),
            'price' => $this->resource->price,
            'score' => $this->resource->score,
            'percent' => $this->resource->percent
        ];
    }
}
