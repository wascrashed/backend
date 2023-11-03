<?php

namespace App\Tbuy\Filial\DTOs;

use App\DTOs\BaseDTO;
use App\Tbuy\Filial\Enums\WorkDay;

class ScheduleDTO extends BaseDTO
{
    public function __construct(
        public readonly string  $open_at,
        public readonly string  $close_at,
        public readonly WorkDay $day,
        public readonly ?string $day_string = null
    )
    {
    }
}
