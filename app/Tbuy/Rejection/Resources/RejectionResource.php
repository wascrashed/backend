<?php

namespace App\Tbuy\Rejection\Resources;

use App\Tbuy\Brand\Models\Brand;
use App\Tbuy\Brand\Resources\BrandResource;
use App\Tbuy\Company\Models\Company;
use App\Tbuy\Company\Resources\CompanyResource;
use App\Tbuy\Product\Models\Product;
use App\Tbuy\Product\Resources\ProductResource;
use App\Tbuy\Reason\Resources\ReasonResource;
use App\Tbuy\Rejection\Models\Rejection;
use App\Tbuy\User\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Rejection $resource
 */
class RejectionResource extends JsonResource
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
            'target' => $this->getModel(),
            'reason' => ReasonResource::make($this->whenLoaded('reason')),
            'image' => $this->resource->image,
            'created_at' => $this->resource->created_at
        ];
    }

    private function getModel()
    {
        if ($this->resource->rejectionable instanceof Brand) {
            return BrandResource::make($this->whenLoaded('rejectionable'));
        }
        if ($this->resource->rejectionable instanceof Company) {
            return CompanyResource::make($this->whenLoaded('rejectionable'));
        }
        if ($this->resource->rejectionable instanceof Product) {
            return ProductResource::make($this->whenLoaded('rejectionable'));
        }
    }
}
