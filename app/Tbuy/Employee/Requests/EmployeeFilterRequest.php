<?php

namespace App\Tbuy\Employee\Requests;

use App\Tbuy\Employee\DTOs\EmployeeFilterDTO;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeFilterRequest extends FormRequest
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
            'company_id' => ['required', Rule::exists('companies', 'id')],
            'username' => ['nullable', 'string', 'max:255', 'min:4'],
            'email' => ['nullable', 'email', 'max:255', 'min:4']
        ];
    }

    public function toDto(): EmployeeFilterDTO
    {
        return new EmployeeFilterDTO(...$this->validated());
    }
}
