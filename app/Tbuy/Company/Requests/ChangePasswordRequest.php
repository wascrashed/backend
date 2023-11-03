<?php

namespace App\Tbuy\Company\Requests;

use App\Tbuy\User\DTOs\ChangePasswordDTO;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ChangePasswordRequest extends FormRequest
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
            'old_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()]
        ];
    }

    public function toDto(): ChangePasswordDTO
    {
        return new ChangePasswordDTO(...array_values([...$this->validated()]));
    }
}
