<?php

namespace App\Http\Resources;

use App\Tbuy\Company\Resources\CompanyResource;
use App\Tbuy\Tariff\Models\TariffLog;
use App\Tbuy\Tariff\Resources\TariffResource;
use App\Tbuy\User\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read TariffLog $resource
 */
class TariffLogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'company' => CompanyResource::make($this->whenLoaded('company')),
            'tariff' => TariffResource::make($this->whenLoaded('tariff')),
            'user' => UserResource::make($this->whenLoaded('user')),
            'tariff_price' => $this->resource->price,
            'expires_at' => $this->resource->created_at->addMonths($this->resource->months)->endOfDay()
        ];
    }
}
