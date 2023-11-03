<?php

namespace App\Tbuy\AttributeValue\Resources;

use App\Tbuy\Attribute\Resources\AttributeResource;
use App\Tbuy\AttributeValue\Models\AttributeValue;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttributeValueResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var AttributeValue $this */

        $response = ['id' => $this->id];

        $response['name'] = $request->get('all')
            ? [
                'ru' => $this->getTranslation('name', 'ru', false),
                'en' => $this->getTranslation('name', 'en', false),
                'hy' => $this->getTranslation('name', 'hy', false)
            ]
            : $this->name;

        $response['attribute'] = AttributeResource::make($this->whenLoaded('attribute'));

        return $response;
    }
}
