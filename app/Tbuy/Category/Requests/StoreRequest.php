<?php

namespace App\Tbuy\Category\Requests;

use App\Tbuy\Category\DTOs\CategoryDTO;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
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
            'name' => 'array',
            'name.ru' => 'required|string|max:100',
            'name.en' => 'required|string|max:100',
            'name.hy' => 'required|string|max:100',
            'slug' => 'required|string|max:100|unique:categories',
            'parent_id' => ['nullable', 'int', Rule::exists('categories', 'id')],
        ];
    }

    /**
     * @return CategoryDTO
     */
    public function toDto(): CategoryDTO
    {
        return new CategoryDTO(...$this->validated());
    }
}
