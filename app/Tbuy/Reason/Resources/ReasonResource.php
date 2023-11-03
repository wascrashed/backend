<?php

namespace App\Tbuy\Reason\Resources;

use App\Tbuy\Reason\Models\Reason;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReasonResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var Reason $this */
        return [
            'id' => $this->id,
            'reason' => $this->reason,
        ];
    }
}
