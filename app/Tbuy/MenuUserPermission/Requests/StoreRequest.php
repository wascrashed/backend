<?php

namespace App\Tbuy\MenuUserPermission\Requests;

use App\Tbuy\MenuUserPermission\DTOs\MenuUserDTO;
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
            'user_id' => ['required', 'integer', Rule::exists('users', 'id')],
            'menu' => 'present|array',
            'menu.*' => ['required', 'integer', Rule::exists('menus', 'id')]
        ];
    }

    public function toDto(): MenuUserDTO
    {
        return new MenuUserDTO(...$this->validated());
    }
}
