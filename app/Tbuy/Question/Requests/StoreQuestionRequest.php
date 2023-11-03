<?php
namespace App\Tbuy\Question\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Tbuy\Question\DTOs\QuestionDTO;
use Illuminate\Validation\Rule;

class StoreQuestionRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'question' => ['array'],
            'question.ru' => ['required', 'string'],
            'question.en' => ['required', 'string'],
            'question.hy' => ['required', 'string'],
            'answer' => ['array'],
            'answer.ru' => ['required', 'string'],
            'answer.en' => ['required', 'string'],
            'answer.hy' => ['required', 'string'],
        ];
    }

    /**
     * @return QuestionDTO
     */
    public function toDto(): QuestionDTO
    {
        return new QuestionDTO(...$this->validated());
    }
}
