<?php

namespace App\Tbuy\Filial\Requests;

use App\Tbuy\Filial\DTOs\CoordinateDTO;
use App\Tbuy\Filial\DTOs\FilialDTO;
use App\Tbuy\Filial\DTOs\ScheduleDTO;
use App\Tbuy\Filial\Enums\WorkDay;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class FilialRequest extends FormRequest
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
            'name' => 'array',
            'name.en' => 'required|string|max:100',
            'name.hy' => 'required|string|max:100',
            'name.ru' => 'required|string|max:100',
            'phone' => 'required|string|max:100',
            'address' => 'required|string|max:100',
            'coordinates' => 'array',
            'coordinates.latitude' => 'required|string|max:100',
            'coordinates.longitude' => 'required|string|max:100',
            'schedule' => 'array|present',
            'schedule.*' => 'array|present',
            'schedule.*.open_at' => 'string|required|max:6',
            'schedule.*.close_at' => 'string|required|max:6',
            'schedule.*.day' => ['required', 'int', new Enum(WorkDay::class)],
            'is_main' => 'required|boolean',
            'community_id' => ['required', 'int', Rule::exists('communities', 'id')],
            'region_id' => ['required', 'int', Rule::exists('regions', 'id')],
        ];
    }

    public function toDto(): FilialDTO
    {
        return new FilialDTO(
            name: $this->get('name'),
            phone: $this->get('phone'),
            address: $this->get('address'),
            coordinates: new CoordinateDTO(...$this->get('coordinates')),
            schedule: array_map(fn(array $schedule) => new ScheduleDTO(
                open_at: $schedule['open_at'],
                close_at: $schedule['close_at'],
                day: WorkDay::tryFrom($schedule['day'])
            ), $this->get('schedule', [])),
            is_main: $this->boolean('is_main'),
            company_id: $this->route('company')->id,
            community_id: $this->get('community_id'),
            region_id: $this->get('region_id')
        );
    }
}
