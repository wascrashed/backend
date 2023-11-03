<?php

namespace App\Tbuy\Vacancy\DTOs;

class VacancyDTO
{
    public function __construct(
        public readonly int $category_id,
        public readonly array $title,
        public readonly array $description,
        public readonly int $salary,
        public readonly array $tags,
        public readonly array $images
    )
    {
    }
}
