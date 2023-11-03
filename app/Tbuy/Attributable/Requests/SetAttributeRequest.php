<?php

namespace App\Tbuy\Attributable\Requests;

use App\Tbuy\Attributable\DTOs\AttributableDTO;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

class SetAttributeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'attribute' => 'present|array',
            'attribute.*' => 'required|array',
            'attribute.*.id' => ['required', 'int', Rule::exists('attributes', 'id')],
            'attribute.*.value' => ['required', 'int', Rule::exists('attribute_values', 'id')],
            'attribute.*.is_name_part' => 'nullable|boolean'
        ];
    }

    public function toCollection(): Collection
    {
        $payload = $this->validated();

        return collect(array_map(
            fn($attribute) => new AttributableDTO(
                attribute_id: $attribute['id'],
                attribute_value_id: $attribute['value'],
                is_name_part: (bool)($attribute['is_name_part'] ?? false)
            ),
            $payload['attribute']
        ));
    }
}
