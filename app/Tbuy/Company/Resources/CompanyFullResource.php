<?php

namespace App\Tbuy\Company\Resources;

use App\Tbuy\Company\Enums\CompanyStatus;
use App\Tbuy\Company\Models\Company;
use App\Tbuy\Rejection\Resources\RejectionResource;
use App\Tbuy\User\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property-read Company $resource
 */
class CompanyFullResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $default = [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'legal_name_company' => $this->resource->legal_name_company,
            'description' => $this->resource->description,
            'type' => $this->resource->type->value,
            'inn' => $this->resource->inn,
            'company_address' => $this->resource->company_address,
            'director' => $this->resource->director->toArray(),
            'phones' => $this->resource->phones->toArray(),
            'email' => $this->resource->email,
            'registered_at' => $this->resource->registered_at->format('Y-m-d H:i:s'),
            'slug' => $this->resource->slug,
            'status' => $this->resource->status->value,
            'legal_entity' => $this->resource->legal_entity, // Добавлено поле legal_entity
            'parent' => CompanyResource::make($this->whenLoaded('parent')),
            'children' => CompanyResource::collection($this->whenLoaded('children')),
            'user' => UserResource::make($this->whenLoaded('user')),
            'documents' => [
                'brand' => $this->whenLoaded('brandDocument',
                    fn() => $this->resource->brandDocument?->getFullUrl()
                ),
                'inn' => $this->whenLoaded('innDocument',
                    fn() => $this->resource->innDocument?->getFullUrl()
                ),
                'passport' => $this->whenLoaded('passportDocument',
                    fn() => $this->resource->passportDocument?->getFullUrl()
                ),
                'state_register' => $this->whenLoaded('stateRegisterDocument',
                    fn() => $this->resource->stateRegisterDocument?->getFullUrl()
                ),
            ],
            'logo' => $this->whenLoaded('logo',
                fn() => $this->resource->logo?->getFullUrl()
            ),
            'socials' => $this->resource->socials->toArray(),
        ];

        return $default + $this->getResponse();
    }

    public function getResponse(): array
    {
        return match ($this->resource->status->value) {
            CompanyStatus::REJECTED->value => $this->rejectedResponse(),
            CompanyStatus::ARCHIVED->value => $this->rejectedResponse(),
            default => []
        };
    }

    protected function rejectedResponse(): array
    {
        return [
            'rejections' => RejectionResource::collection($this->whenLoaded('rejections'))
        ];
    }
}
