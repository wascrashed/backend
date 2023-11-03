<?php

namespace App\Tbuy\Settings\Repositories;

use App\Tbuy\Settings\DTOs\SettingsDTO;
use App\Tbuy\Settings\Models\Settings;
use Illuminate\Database\Eloquent\Collection;

class SettingsRepositoryImplementation implements SettingsRepository
{
    public function get(): Collection
    {
        return Settings::query()->get();
    }

    public function update(SettingsDTO $settingsDTO, Settings $settings): Settings
    {
        $settings->fill([
            'value' => $settingsDTO->value,
        ]);
        $settings->save();

        return $settings;
    }
}
