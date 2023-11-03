<?php

namespace App\Tbuy\Company\Requests;

use App\Tbuy\Company\DTOs\CompanyStatusDTO;
use App\Tbuy\Company\Enums\CompanyStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class CompanyToggleStatusRequest extends FormRequest
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
            'status' => ['required', 'string', new Enum(CompanyStatus::class)],
            'reason_id' => [
                'nullable',
                'required_if:status,' . CompanyStatus::REJECTED->value,
                'integer',
                Rule::exists('reasons', 'id')
            ]
        ];
    }

    public function toDto(): CompanyStatusDTO
    {
        return new CompanyStatusDTO(...$this->validated());
    }
}
