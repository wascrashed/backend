<?php

namespace App\Tbuy\Locale\Repositories;

use App\Tbuy\Locale\DTOs\LocaleDTO;
use App\Tbuy\Locale\Models\Locale;
use Illuminate\Database\Eloquent\Collection;

interface LocaleRepository
{
    public function get(): Collection;

    public function create(LocaleDTO $payload): Locale;

    public function update(Locale $locale, LocaleDTO $payload): Locale;
}
