<?php

namespace App\Tbuy\Company\Requests;

use App\Tbuy\User\DTOs\ForgotPasswordDTO;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
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
            'email' => 'required|email|max:50|exists:users,email',
        ];
    }

    public function toDto(): ForgotPasswordDTO
    {
        return new ForgotPasswordDTO(...$this->validated());
    }
}
