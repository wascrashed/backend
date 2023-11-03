<?php

namespace App\Tbuy\Banner\Requests;

use App\Tbuy\Banner\DTOs\BannerDTO;
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
        return [
            'name' => 'present|array',
            'name.ru' => 'required|string|max:100',
            'name.en' => 'required|string|max:100',
            'name.hy' => 'required|string|max:100',
            'content' => 'required|array',
            'company_id' => ['required', 'int', Rule::exists('companies', 'id')->where('deleted_at')]
        ];
    }

    public function toDto(): BannerDTO
    {
        return new BannerDTO(...$this->validated());
    }
}
