<?php

namespace App\Tbuy\Company\Requests;

use App\Tbuy\Company\DTOs\CompanyFilterDTO;
use App\Tbuy\Company\Enums\CompanyStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CompanyFilterRequest extends FormRequest
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
            'status' => 'nullable|string',
            'parent' => 'nullable|boolean'
        ];
    }

    public function toDto(): CompanyFilterDTO
    {
        $status = $this->get('status')
            ? CompanyStatus::tryFrom($this->get('status'))
            : null;
        return new CompanyFilterDTO(
            status: $status,
            parent: $this->boolean('parent')
        );
    }
}
