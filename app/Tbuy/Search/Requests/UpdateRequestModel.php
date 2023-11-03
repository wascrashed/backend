<?php

namespace App\Tbuy\Search\Requests;

use App\Tbuy\Search\DTOs\SearchableModelDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequestModel extends FormRequest
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
            'model_id' => ['required', 'int', Rule::exists('model_lists', 'id')],
            'priority' => 'required|int',
            'count' => 'required|int',
        ];
    }

    /**
     * @return SearchableModelDTO
     */
    public function toDto(): SearchableModelDTO
    {
        return new SearchableModelDTO(...$this->validated());
    }
}
