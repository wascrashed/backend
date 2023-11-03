<?php

namespace App\Tbuy\Search\DTOs;

use App\DTOs\BaseDTO;

class SearchableFieldDTO extends BaseDTO
{
    public function __construct(
        public readonly int $model_field_id,
        public readonly int $searchable_model_id,
        public readonly int $priority,
    )
    {
    }
}
