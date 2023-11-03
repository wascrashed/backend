<?php

namespace App\Tbuy\Brand\Requests;

use App\Tbuy\Brand\DTOs\BrandFetchDTO;
use App\Tbuy\Brand\Enums\BrandStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class BrandFilterRequest extends FormRequest
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
            'brand_id' => ['nullable', 'int'],
            'reason_id' => ['nullable', Rule::exists('reasons', 'id')],
            'date' => 'nullable|string|date|date_format:Y-m-d',
            'company' => ['nullable', 'int', Rule::exists('companies', 'id')],
            'category' => ['nullable', 'int', Rule::exists('categories', 'id')],
            'status' => ['nullable', new Enum(BrandStatus::class)]
        ];
    }

    public function toDto(): BrandFetchDTO
    {
        return new BrandFetchDTO(...$this->validated());
    }
}
