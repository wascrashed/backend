<?php

namespace App\Tbuy\Brand\Requests;

use App\Tbuy\Brand\DTOs\BrandStatusDTO;
use App\Tbuy\Brand\Enums\BrandStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class SetStatusRequest extends FormRequest
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
        $rejected = BrandStatus::REJECTED->value;
        return [
            'status' => ['required', new Enum(BrandStatus::class)],
            'reason_id' => [
                "nullable",
                "required_if:status,$rejected",
                "integer",
                Rule::exists("reasons", "id")
            ]
        ];
    }

    public function toDTO(): BrandStatusDTO
    {
        $payload = $this->validated();
        return new BrandStatusDTO(...$payload);
    }
}
