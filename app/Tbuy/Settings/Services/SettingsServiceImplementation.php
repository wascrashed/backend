<?php

namespace App\Tbuy\Settings\Services;

use App\Tbuy\Settings\DTOs\SettingsDTO;
use App\Tbuy\Settings\Models\Settings;
use App\Tbuy\Settings\Repositories\SettingsRepository;
use App\Tbuy\Settings\Enums\SettingsCacheKey;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SettingsServiceImplementation implements SettingsService
{
    public function __construct(
        protected readonly SettingsRepository $settingsRepository,
    ) {
    }

    public function get(): Collection
    {
        return Cache::tags(SettingsCacheKey::LIST->value)
            ->remember(SettingsCacheKey::LIST->value, SettingsCacheKey::ttl(), function () {
                return $this->settingsRepository->get();
            });
    }

    public function update(SettingsDTO $settingsDTO, Settings $settings): Settings
    {
        $settings = $this->settingsRepository->update($settingsDTO, $settings);

        Cache::tags(SettingsCacheKey::LIST->value)->clear();

        return $settings;
    }
}
