<?php

namespace App\Tbuy\Vacancy\Requests\VacancyCategory;

use App\Tbuy\Vacancy\DTOs\VacancyCategoryDTO;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['array'],
            'name.ru' => ['required', 'string', 'max:255'],
            'name.en' => ['required', 'string', 'max:255'],
            'name.hy' => ['required', 'string', 'max:255']
        ];
    }

    public function toDto(): VacancyCategoryDTO
    {
        return new VacancyCategoryDTO(...$this->validated());
    }
}
