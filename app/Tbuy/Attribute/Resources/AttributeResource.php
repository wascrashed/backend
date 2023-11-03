<?php

namespace App\Tbuy\Attribute\Resources;

use App\Tbuy\Attribute\Models\Attribute;
use App\Tbuy\AttributeValue\Resources\AttributeValueResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttributeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Attribute $this */

        $response = [
            'id' => $this->id
        ];

        $response['name'] = $request->get('all')
            ? [
                'ru' => $this->getTranslation('name', 'ru', false),
                'en' => $this->getTranslation('name', 'en', false),
                'hy' => $this->getTranslation('name', 'hy', false),
            ]
            : $this->name;

        $response['values'] = AttributeValueResource::collection($this->whenLoaded('values'));

        return $response;
    }
}
