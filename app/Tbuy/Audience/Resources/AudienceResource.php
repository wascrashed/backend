<?php

namespace App\Tbuy\Audience\Resources;

use App\Tbuy\Audience\Models\Audience;
use App\Tbuy\Company\Resources\CompanyResource;
use App\Tbuy\Country\Resources\CountryResource;
use App\Tbuy\Region\Resources\RegionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Audience $resource
 */
class AudienceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'company' => new CompanyResource($this->whenLoaded('company')),
            'country' => new CountryResource($this->whenLoaded('country')),
            'region' => new RegionResource($this->whenLoaded('region')),
            'gender' => $this->resource->gender->value,
            'age' => $this->resource->age,
        ];
    }
}
