<?php

namespace App\Tbuy\Locale\Requests;

use App\Tbuy\Locale\DTOs\LocaleDTO;
use App\Tbuy\Locale\Models\Locale;
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
        /** @var Locale $locale */
        $locale = $this->route('locale');

        return [
            'name' => 'required|string|max:100',
            'locale' => [
                'required',
                'string',
                Rule::unique('locales', 'locale')->ignore($locale->id)
            ]

        ];
    }

    public function toDto(): LocaleDTO
    {
        return new LocaleDTO(...$this->validated());
    }
}
