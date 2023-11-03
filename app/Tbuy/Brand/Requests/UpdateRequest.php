<?php

namespace App\Tbuy\Brand\Requests;

use App\Tbuy\Brand\DTOs\BrandDTO;
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
            'name' => 'array',
            'name.ru' => 'required|string|max:100',
            'name.en' => 'required|string|max:100',
            'name.hy' => 'required|string|max:100',
            'description' => 'array',
            'description.ru' => 'required|string|max:1000',
            'description.en' => 'required|string|max:1000',
            'description.hy' => 'required|string|max:1000',
            'country_id' => ['required', 'int', Rule::exists('countries', 'id')],
            'company_id' => ['required', 'int', Rule::exists('companies', 'id')],
            'date' => 'required|date|date_format:Y-m-d',
            'logo' => 'nullable|file|image|mimes:jpg,jpeg,png|max:' . (1024 * 10)
        ];
    }

    public function toDto(): BrandDTO
    {
        return new BrandDTO(...$this->validated());
    }
}
