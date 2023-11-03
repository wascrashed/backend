<?php

namespace App\Tbuy\Tariff\Resources;

use App\Tbuy\Tariff\Models\TariffPrivilege;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read TariffPrivilege $resource
 */
class TariffPrivilegeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|string
     */
    public function toArray(Request $request): array|string
    {
        return [
            'name' => $this->resource->name,
        ];
    }
}
