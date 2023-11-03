<?php

namespace App\Tbuy\Company\DTOs;

use App\DTOs\BaseDTO;

class DirectorDTO extends BaseDTO
{
    public function __construct(
        public string $last_name,
        public string $first_name
    )
    {
    }
}
