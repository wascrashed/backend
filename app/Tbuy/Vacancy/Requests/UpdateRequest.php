<?php

namespace App\Tbuy\Vacancy\Requests;

use App\Tbuy\Vacancy\DTOs\VacancyDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'int', Rule::exists('vacancy_categories', 'id')->where('deleted_at')],
            'title' => ['array'],
            'title.ru' => ['required', 'string', 'max:255'],
            'title.en' => ['required', 'string', 'max:255'],
            'title.hy' => ['required', 'string', 'max:255'],
            'description' => ['array'],
            'description.ru' => ['required', 'string', 'max:1000'],
            'description.en' => ['required', 'string', 'max:1000'],
            'description.hy' => ['required', 'string', 'max:1000'],
            'salary' => ['required', 'int'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['required', 'string', 'max:55'],
            'images' => ['nullable', 'array'],
            'images.*' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:' . (1024 * 10)]
        ];
    }

    public function toDto(): VacancyDTO
    {
        return new VacancyDTO(...$this->validated());
    }
}
