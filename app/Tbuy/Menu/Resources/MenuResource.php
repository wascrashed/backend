<?php

namespace App\Tbuy\Menu\Resources;

use App\Tbuy\Menu\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Menu $this */
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'image' => $this->image?->getUrl(),
            'children' => static::collection($this->whenLoaded('grandChildren'))
        ];
    }
}
