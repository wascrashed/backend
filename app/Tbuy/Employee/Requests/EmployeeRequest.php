<?php

namespace App\Tbuy\Employee\Requests;

use App\Tbuy\Employee\DTOs\EmployeeDTO;
use App\Tbuy\Employee\Models\CompanyEmployee;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeRequest extends FormRequest
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
        /** @var CompanyEmployee $employee */
        $employee = $this->route('employee');

        return [
            'company_id' => ['required', Rule::exists('companies', 'id')],
            'email' => ['required', 'email', Rule::exists('users', 'email')],
            'username' => [
                'required',
                'string',
                $this->isMethod('post') ?
                    Rule::unique('company_employees', 'username') :
                    Rule::unique('company_employees', 'username')->ignoreModel($employee)
            ]
        ];
    }

    public function toDto(): EmployeeDTO
    {
        return new EmployeeDTO(...$this->validated());
    }
}
