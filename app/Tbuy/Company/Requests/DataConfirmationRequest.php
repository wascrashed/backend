<?php

namespace App\Tbuy\Company\Requests;

use App\Tbuy\Company\DTOs\CompanyDataConfirmationDTO;
use App\Tbuy\Company\Models\Company;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DataConfirmationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        /** @var Company $company */
        $company = $this->route('company');

        return [
            'bank_account' => ['required', 'string', 'min:12', 'max:50', Rule::unique('companies', 'bank_account')->ignoreModel($company)],
            'tariff_conditions_accepted_at' => 'required|date',
            'basic_agreement_accepted_at' => 'required|date',
        ];
    }

    /**
     * @return CompanyDataConfirmationDTO
     */
    public function toDto(): CompanyDataConfirmationDTO
    {
        return new CompanyDataConfirmationDTO(...$this->validated());
    }
}
