<?php

namespace App\Tbuy\Rejection\Requests;

use App\Enums\MorphType;
use App\Tbuy\Brand\DTOs\Rejection\RejectionFilterDTO;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class IndexRejectionsRequest extends FormRequest
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
            'type' => ['required', 'string', new Enum(MorphType::class)],
            'reason' => ['nullable', 'array', Rule::exists('reasons', 'id')],
            'id' => 'nullable|int',
            'user' => 'nullable|int|exists:users,id',
            'date' => 'nullable|date|date_format:Y-m-d',
            'name' => 'nullable|string',
            'company' => 'nullable|int',
            'category_id' => ['nullable', Rule::exists('categories', 'id')]
        ];
    }

    public function toDto(): RejectionFilterDTO
    {
        return new RejectionFilterDTO(...$this->validated());
    }
}
