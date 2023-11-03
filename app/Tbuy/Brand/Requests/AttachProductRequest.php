<?php

namespace App\Tbuy\Brand\Requests;

use App\Tbuy\Brand\DTOs\BrandAttachProductDTO;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AttachProductRequest extends FormRequest
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
            'product' => 'present|array',
            'product.*' => ['required', 'int', Rule::exists('products', 'id')]
        ];
    }

    public function toDto(): BrandAttachProductDTO
    {
        return new BrandAttachProductDTO(product: $this->get('product'));
    }
}
