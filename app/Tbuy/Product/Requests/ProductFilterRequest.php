<?php

namespace App\Tbuy\Product\Requests;

use App\Tbuy\Product\DTOs\ProductDTO;
use App\Tbuy\Product\Enums\ProductStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class ProductFilterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'from' => ['required_with:to', 'date'],
            'to' => ['required_with:from,', 'date'],
            'name' => ['nullable', 'string', 'max:200'],
            'id' => ['nullable', 'integer'],
            'category_id' => ['nullable', Rule::exists('categories', 'id')],
            'before_declined' => ['nullable', 'boolean'],
            'before_accepted' => ['nullable', 'boolean'],
            'status' => ['nullable', new Enum(ProductStatus::class)],
            'active' => ['nullable', 'boolean'],
            'last_accepted' => ['nullable', 'boolean'],
            'limit' => ['nullable', 'int'],
            'orderDirection' => ['nullable', 'string'],
            'zero_amount' => ['nullable', 'boolean'],
            'reason_id' => ['nullable', Rule::exists('reasons', 'id')]
        ];
    }

    public function toDto(): ProductDTO
    {
        return new ProductDTO(...$this->validated());
    }
}
