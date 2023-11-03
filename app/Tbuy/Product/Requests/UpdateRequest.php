<?php

namespace App\Tbuy\Product\Requests;

use App\Enums\MorphType;
use App\Tbuy\Product\DTOs\ProductUpdateDTO;
use App\Tbuy\Product\DTOs\VisibleFieldsDTO;
use App\Tbuy\Product\Enums\ProductType;
use App\Tbuy\Product\Models\Product;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UpdateRequest extends FormRequest
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
            'images' => 'array',
            'images.*' => 'required|file|mimes:jpg,jpeg,png,mp4|max:' . (10 * 1024),
            'category_id' => ['required', Rule::exists('categories', 'id')],
            'amount' => ['required', 'numeric'],
            'price' => ['required', 'numeric'],
            'type' => ['required', new Enum(ProductType::class)],
            'active' => ['nullable', 'boolean'],
            'brand_id' => ['nullable', Rule::exists('brands', 'id')],
            'description' => 'array',
            'description.ru' => 'required|string',
            'description.en' => 'required|string',
            'description.hy' => 'required|string',
            'visible_fields' => 'present|array',
            'visible_fields.*' => 'string|max:50',

        ];
    }

    public function toDto(): ProductUpdateDTO
    {
        $validated = $this->validated();
        $validated['visible_fields'] = new VisibleFieldsDTO($validated['visible_fields']);

        return new ProductUpdateDTO(...$validated);
    }
}
