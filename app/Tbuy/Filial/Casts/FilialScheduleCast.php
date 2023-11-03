<?php

namespace App\Tbuy\Filial\Casts;

use App\Tbuy\Filial\DTOs\ScheduleDTO;
use App\Tbuy\Filial\Enums\WorkDay;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class FilialScheduleCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param array<string, mixed> $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): array
    {
        $scheduleList = $this->decodeJsonString($value);

        return $this->addToDTO($scheduleList);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param array<int, ScheduleDTO> $value
     * @param array<string, mixed> $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        return json_encode(
            array_map(fn(ScheduleDTO $schedule) => Arr::except($schedule->toArray(), 'day_string'), $value)
        );
    }

    private function decodeJsonString(?string $value): array
    {
        if (is_null($value)) {
            return [];
        }

        return json_decode($value, true);
    }

    private function addToDTO(array $scheduleList): array
    {
        return array_map(
            function (array $schedule) {
                $day = WorkDay::tryFrom($schedule['day']);
                return new ScheduleDTO(
                    open_at: $schedule['open_at'],
                    close_at: $schedule['close_at'],
                    day: $day,
                    day_string: $day->getStringValue()
                );
            }, $scheduleList);
    }
}
