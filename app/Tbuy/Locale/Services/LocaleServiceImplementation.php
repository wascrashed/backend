<?php

namespace App\Tbuy\Locale\Services;

use App\Tbuy\Locale\DTOs\LocaleDTO;
use App\Tbuy\Locale\Enums\CacheKey;
use App\Tbuy\Locale\Models\Locale;
use App\Tbuy\Locale\Repositories\LocaleRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class LocaleServiceImplementation implements LocaleService
{
    public function __construct(private readonly LocaleRepository $localeRepository)
    {
    }

    public function get(): Collection
    {
        return Cache::remember(CacheKey::LOCALE_LIST->value, CacheKey::ttl(), function () {
            return $this->localeRepository->get();
        });
    }

    public function create(LocaleDTO $payload): Locale
    {
        $locale = $this->localeRepository->create($payload);

        Cache::forget(CacheKey::LOCALE_LIST->value);

        return $locale;
    }

    public function update(Locale $locale, LocaleDTO $payload): Locale
    {
        $locale = $this->localeRepository->update($locale, $payload);

        Cache::forget(CacheKey::LOCALE_LIST->value);

        return $locale;
    }
}
