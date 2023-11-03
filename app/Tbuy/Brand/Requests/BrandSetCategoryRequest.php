<?php

namespace App\Tbuy\Brand\Requests;

use App\Tbuy\Brand\DTOs\BrandCategoryDTO;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BrandSetCategoryRequest extends FormRequest
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
            'category' => 'present|array',
            'category.*' => ['required', 'int', Rule::exists('categories', 'id')]
        ];
    }

    public function toDto(): BrandCategoryDTO
    {
        return new BrandCategoryDTO(...$this->validated());
    }
}
