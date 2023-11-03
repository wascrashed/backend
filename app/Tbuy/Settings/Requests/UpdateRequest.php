<?php

namespace App\Tbuy\Settings\Requests;

use App\Tbuy\Settings\DTOs\SettingsDTO;
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
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'value' => 'required|string|max:200',
        ];
    }

    public function toDto(): SettingsDTO
    {
        return new SettingsDTO(...$this->validated());
    }
}
