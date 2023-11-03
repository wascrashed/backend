<?php

namespace App\Tbuy\Product\Requests;

use App\Tbuy\Product\DTOs\ProductToggleStatusDTO;
use App\Tbuy\Product\Enums\ProductStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class ToggleStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'status' => ['required', 'string', new Enum(ProductStatus::class)],
            'reason_id' => [
                'nullable',
                'required_if:status,' . ProductStatus::REJECTED->value,
                'int',
                'exists:reasons,id'
            ]
        ];
    }

    public function toDto(): ProductToggleStatusDTO
    {
        return new ProductToggleStatusDTO(
            status: ProductStatus::tryFrom($this->request->get('status')),
            reason_id: $this->request->get('reason_id')
        );
    }
}
