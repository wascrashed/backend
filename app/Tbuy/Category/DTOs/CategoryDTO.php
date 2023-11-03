<?php

namespace App\Tbuy\Category\DTOs;

use App\DTOs\BaseDTO;

class CategoryDTO extends BaseDTO
{
    public function __construct(
        public readonly array $name,
        public readonly string $slug,
        public readonly ?int $parent_id = null,
    )
    {
    }
}
