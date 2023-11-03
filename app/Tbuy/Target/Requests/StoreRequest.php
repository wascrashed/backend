<?php

namespace App\Tbuy\Target\Requests;

use App\Tbuy\Target\DTOs\TargetDTO;
use App\Tbuy\Target\Enums\Targetable;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $targetable = $this->getTargetable();

        return [
            'audience_id' => ['required', 'int', Rule::exists('audiences', 'id')],
            'targetable_type' => ['required', 'string', 'in:' . join(',', Targetable::names())],
            'targetable_id' => ['required', 'int', Rule::exists($targetable, 'id')],
            'name' => ['required', 'array'],
            'name.ru' => ['required', 'string', 'max:100'],
            'name.en' => ['required', 'string', 'max:100'],
            'name.hy' => ['required', 'string', 'max:100'],
            'link' => ['required', 'string'],
            'duration' => ['required', 'int', 'max:-1', 'min:-30'],
            'started_at' => ['required', 'string'],
            'finished_at' => ['required', 'string', 'date']
        ];
    }

    public function toDto(): TargetDTO
    {
        return new TargetDTO(...$this->validated());
    }

    private function getTargetable(): string
    {
        if ($this->filled('targetable_type')) {
            $cases = Targetable::cases();
            $index = array_search($this->input('targetable_type'), array_column($cases, 'name'));

            return $cases[$index ?? 0]->value;
        }

        return '';
    }
}
