<?php

namespace App\Tbuy\Product\DTOs;

use App\DTOs\BaseDTO;

class VisibleFieldsDTO extends BaseDTO
{

    public function __construct(
        public readonly array $fields
    )
    {

    }
}
