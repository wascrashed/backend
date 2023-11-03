<?php

namespace App\Tbuy\AttributeValue\Requests;

use App\Tbuy\AttributeValue\DTOs\AttributeValueDTO;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
            'name' => 'array|size:3',
            'name.ru' => 'required|string|max:100',
            'name.en' => 'required|string|max:100',
            'name.hy' => 'required|string|max:100',
            'attribute_id' => ['required', 'int', Rule::exists('attributes', 'id')]
        ];
    }

    public function toDto(): AttributeValueDTO
    {
        return new AttributeValueDTO(...$this->validated());
    }
}
