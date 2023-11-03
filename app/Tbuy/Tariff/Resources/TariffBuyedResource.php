<?php

namespace App\Tbuy\Tariff\Resources;

use App\Tbuy\User\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TariffBuyedResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'user' => UserResource::make($this->resource['user']),
            'tariff' => TariffResource::make($this->resource['tariff']),
            'expired_at' => $this->resource['user']->tariff()->latest()->first()->pivot->expired_at,
            'percent' => $this->resource['user']->tariff()->latest()->first()->percent,
        ];
    }
}
