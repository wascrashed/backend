<?php

namespace App\Tbuy\Locale\Repositories;

use App\Tbuy\Locale\DTOs\LocaleDTO;
use App\Tbuy\Locale\Models\Locale;
use Illuminate\Database\Eloquent\Collection;

class LocaleRepositoryImplementation implements LocaleRepository
{
    public function get(): Collection
    {
        return Locale::query()
            ->orderBy('name')
            ->get();
    }

    public function create(LocaleDTO $payload): Locale
    {
        $locale = new Locale([
            'name' => $payload->name,
            'locale' => $payload->locale
        ]);
        $locale->save();

        return $locale;
    }

    public function update(Locale $locale, LocaleDTO $payload): Locale
    {
        $locale->fill([
            'name' => $payload->name,
            'locale' => $payload->locale
        ]);
        $locale->save();

        return $locale;
    }
}
