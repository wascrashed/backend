<?php

namespace App\Tbuy\Employee\Resources;

use App\Tbuy\Company\Resources\CompanyResource;
use App\Tbuy\Employee\Models\CompanyEmployee;
use App\Tbuy\User\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read CompanyEmployee $resource
 */
class EmployeeResource extends JsonResource
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
            'user' => UserResource::make($this->whenLoaded('user')),
            'username' => $this->resource->username,
            'company' => CompanyResource::make($this->whenLoaded('company')),
            'registered_at' => $this->resource->created_at,
        ];
    }
}
