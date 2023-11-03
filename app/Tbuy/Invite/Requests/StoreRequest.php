<?php

namespace App\Tbuy\Invite\Requests;

use App\Tbuy\Invite\DTOs\InviteDTO;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
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
            'company_id' => ['required', 'int', Rule::exists('companies', 'id')],
            'email' => 'required|string|max:100|email',
            'username' => 'required|string|max:100',
            'expired_at' => 'required|date|date_format:Y-m-d'
        ];
    }

    public function toDto(): InviteDTO
    {
        return new InviteDTO(...$this->validated());
    }
}
