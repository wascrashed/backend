<?php

namespace App\Tbuy\Rejection\Requests;

use App\Tbuy\Rejection\DTOs\RejectionDTO;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RejectionsUpdateRequest extends FormRequest
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
            'reason_id' => ['required', Rule::exists('reasons', 'id')],
        ];
    }

    public function toDto(): RejectionDTO
    {
        return new RejectionDTO(...$this->validated());
    }
}
