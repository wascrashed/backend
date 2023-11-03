<?php

namespace App\Tbuy\Tariff\Requests;

use App\Tbuy\Tariff\DTOs\TariffLogFilterDTO;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TariffLogFilterRequest extends FormRequest
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
            'user_id' => 'nullable|int',
            'tariff_id' => 'nullable|int',
            'company_id' => 'nullable|int'
        ];
    }

    public function toDto(): TariffLogFilterDTO
    {
        return new TariffLogFilterDTO(...$this->validated());
    }
}
