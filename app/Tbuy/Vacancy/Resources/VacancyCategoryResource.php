<?php

namespace App\Tbuy\Vacancy\Resources;

use App\Tbuy\Vacancy\Models\VacancyCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read VacancyCategory $resource
 */
class VacancyCategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name
        ];
    }
}
