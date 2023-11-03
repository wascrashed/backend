<?php

namespace App\Tbuy\Templates\DTOs;

class TemplatesDTO
{
    public function __construct(
        public readonly string $name,
        public readonly ?int   $banner_id = null,
    )
    {
    }
}
