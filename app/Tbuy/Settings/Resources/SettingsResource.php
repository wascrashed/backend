<?php

namespace App\Tbuy\Settings\Resources;

use App\Tbuy\Settings\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Settings $resource
 */
class SettingsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'type' => $this->resource->type,
            'variable' => $this->resource->variable,
            'value' => $this->resource->value
        ];
    }
}
