<?php

namespace App\Tbuy\Locale\DTOs;

class LocaleDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $locale
    )
    {
    }
}
