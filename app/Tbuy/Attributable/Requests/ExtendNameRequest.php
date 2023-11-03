<?php

namespace App\Tbuy\Attributable\Requests;

use App\Enums\MorphType;
use App\Tbuy\Attributable\DTOs\ExtendNameDTO;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

class ExtendNameRequest extends FormRequest
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
        $model = $this->getModel();
        $type = MorphType::getType($model::class);

        return [
            'attributes' => 'required|array',
            'attributes.*' => 'array|required',
            'attributes.*.attribute_id' => [
                'required',
                'int',
                Rule::exists('attributable', 'attribute_id')
                    ->where('attributable_type', $type)
                    ->where('attributable_id', $model->id)
            ],
            'attributes.*.is_name_part' => 'boolean'
        ];
    }

    public function toCollection(): Collection
    {
        return collect($this->validated('attributes', []))
            ->map(
                fn(array $attribute) => new ExtendNameDTO(...$attribute)
            );
    }

    private function getModel(): object
    {
        $routeName = $this->route()->parameterNames[0];

        return $this->route($routeName);
    }
}
