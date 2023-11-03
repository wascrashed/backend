<?php

namespace App\Tbuy\Target\Resources;

use App\Tbuy\Audience\Resources\AudienceResource;
use App\Tbuy\Target\Models\Target;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Target $resource
 */
class TargetResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'audience' => new AudienceResource($this->whenLoaded('audience')),
            'targetable' => $this->resource->targetable,
            'name' => $this->resource->name,
            'link' => $this->resource->link,
            'duration' => $this->resource->duration,
            'status' => $this->resource->status->value,
            'views' => $this->resource->views,
            'started_at' => $this->resource->started_at->format('Y-m-d-m-Y-H-i-s'),
            'finished_at' => $this->resource->finished_at->format('Y-m-d-m-Y-H-i-s'),
        ];
    }
}
