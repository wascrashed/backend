<?php

namespace App\Tbuy\Vacancy\DTOs;

class VacancyCategoryDTO
{
    public function __construct(
        public readonly array $name
    )
    {
    }
}
