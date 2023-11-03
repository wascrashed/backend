<?php

namespace App\Tbuy\Settings\Services;

use App\Tbuy\Settings\DTOs\SettingsDTO;
use App\Tbuy\Settings\Models\Settings;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as CollectionAllias;

interface SettingsService
{
    public function get(): Collection;

    public function update(SettingsDTO $settingsDTO, Settings $settings): Settings;
}
