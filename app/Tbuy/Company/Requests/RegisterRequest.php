<?php

namespace App\Tbuy\Company\Requests;

use App\Tbuy\Company\DTOs\CompanyDTO;
use App\Tbuy\Company\DTOs\DirectorDTO;
use App\Tbuy\Company\DTOs\PhonesDTO;
use App\Tbuy\Company\Enums\CompanyStatus;
use App\Tbuy\Company\Enums\CompanyType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string|min:4|max:100',
            'type' => ['required', 'string', new Enum(CompanyType::class)],
            'director' => 'array',
            'director.first_name' => 'required|string|max:100',
            'director.last_name' => 'required|string|max:100',
            'phones' => 'array',
            'phones.phone_director' => ['required', 'string', 'max:20', Rule::unique('companies', 'phones->phone_director')],
            'email' => ['required', 'email', Rule::unique('companies', 'email'), Rule::unique('users', 'email')],
            'inn' => 'required|string|max:20|unique:companies,inn',
            'inn_document' => 'required|file|mimes:jpg,jpeg,png,pdf|max:' . (1024 * 5),
            'passport_document' => 'required|file|mimes:jpg,jpeg,png,pdf|max:' . (1024 * 5),
            'state_register_document' => 'required|file|mimes:jpg,jpeg,png,pdf|max:' . (1024 * 5),
        ];
    }

    /**
     * @return CompanyDTO
     */
    public function toDto(): CompanyDTO
    {
        $payload = $this->validated();
        $payload['director'] = new DirectorDTO(...$payload['director']);
        $payload['type'] = CompanyType::tryFrom($payload['type']);
        $payload['slug'] = Str::slug($payload['name'] . ' ' . now()->getTimestamp());
        $payload['name'] = [
            'ru' => $payload['name'],
            'en' => $payload['name'],
            'hy' => $payload['name']
        ];
        $payload['status'] = CompanyStatus::NEW->value;
        $payload['phones'] = new PhonesDTO($payload['phones']['phone_director']);

        return new CompanyDTO(...$payload);
    }
}

