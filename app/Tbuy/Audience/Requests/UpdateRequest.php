<?php

namespace App\Tbuy\Audience\Requests;

use App\Tbuy\Audience\DTOs\AudienceDTO;
use App\Tbuy\Audience\Enums\Gender;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['array'],
            'name.ru' => ['required', 'string', 'max:100'],
            'name.en' => ['required', 'string', 'max:100'],
            'name.hy' => ['required', 'string', 'max:100'],
            'company_id' => ['required', 'int', Rule::exists('companies', 'id')],
            'country_id' => ['required', 'int', Rule::exists('countries', 'id')],
            'region_id' => ['required', 'int', Rule::exists('regions', 'id')],
            'gender' => ['required', 'string', new Enum(Gender::class)],
            'age' => ['array'],
            'age.min' => ['required', 'int'],
            'age.max' => ['required', 'int', 'min:' . $this->input('age.min')]
        ];
    }

    public function toDto(): AudienceDTO
    {
        return new AudienceDTO(...$this->validated());
    }
}
