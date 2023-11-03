<?php

namespace App\Tbuy\Vacancy\Resources;

use App\Tbuy\Vacancy\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property-read Vacancy $resource
 */
class VacancyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'title' => $this->resource->title,
            'description' => $this->resource->description,
            'salary' => $this->resource->salary,
            'category' => new VacancyCategoryResource($this->resource->category),
            'tags' => $this->whenLoaded('tags'),
            'images' => $this->resource->images->map(function (?Media $image) {
                return $image?->getUrl();
            })->toArray()
        ];
    }
}
