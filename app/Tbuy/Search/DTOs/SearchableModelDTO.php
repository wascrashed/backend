<?php

namespace App\Tbuy\Search\DTOs;

class SearchableModelDTO
{
    public function __construct(
        public readonly int $model_id,
        public readonly int $priority,
        public readonly int $count,
    )
    {
    }
}
