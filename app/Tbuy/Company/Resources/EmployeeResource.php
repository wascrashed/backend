<?php

namespace App\Tbuy\Company\Resources;
use Illuminate\Http\Request;

use App\Tbuy\User\Resources\UserResource;

class EmployeeResource extends UserResource
{
    /**

    @property-read User $resource
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->user->id,
            'name' => $this->resource->user->name,
            'email' => $this->resource->user->email,
            'balance' => $this->resource->user->balance,
            'created_at' => $this->resource->user->created_at
        ];
    }
}
