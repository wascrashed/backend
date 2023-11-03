<?php

namespace App\Tbuy\Settings\Repositories;

use App\Tbuy\Settings\DTOs\SettingsDTO;
use App\Tbuy\Settings\Models\Settings;
use Illuminate\Database\Eloquent\Collection;

interface SettingsRepository
{
    public function get(): Collection;

    public function update(SettingsDTO $settingsDTO, Settings $settings): Settings;
}
