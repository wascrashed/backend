<?php

namespace App\Tbuy\Target\Requests;

use App\Tbuy\Target\DTOs\TargetStatusDTO;
use App\Tbuy\Target\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class ChangeStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', 'string', new Enum(Status::class)]
        ];
    }

    public function toDto(): TargetStatusDTO
    {
        return new TargetStatusDTO(...$this->validated());
    }
}
