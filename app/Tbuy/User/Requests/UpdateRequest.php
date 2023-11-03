<?php

namespace App\Tbuy\User\Requests;

use App\Tbuy\User\DTOs\UserDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

 class UpdateRequest  extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . ($this->user ? $this->user->id : 'NULL'),
            'password' => ['required', 'confirmed', Password::defaults()]
        ];
    }
       /**
     * @return UserDTO
     */
    public function toDto(): UserDTO
    {
        return new UserDTO(...$this->validated());
    }
}
