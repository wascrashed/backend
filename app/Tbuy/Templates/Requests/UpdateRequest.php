<?php

namespace App\Tbuy\Templates\Requests;

use App\Tbuy\Templates\DTOs\TemplatesDTO;
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
            'name' => 'required|string|max:100',
            'banner_id' => ['nullable', 'int', Rule::exists('banners', 'id')->whereNull('deleted_at')],
        ];
    }

    /**
     * @return TemplatesDTO
     */
    public function toDto(): TemplatesDTO
    {
        return new TemplatesDTO(...$this->validated());
    }
}
