<?php

namespace App\Tbuy\Locale\Resources;

use App\Tbuy\Locale\Models\Locale;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LocaleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Locale $this */
        return [
            'id' => $this->id,
            'name' => $this->name,
            'locale' => $this->locale
        ];
    }
}
