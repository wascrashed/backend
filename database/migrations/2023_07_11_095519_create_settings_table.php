<?php

use App\Tbuy\Settings\Enums\SettingsType;
use App\Tbuy\Settings\Enums\SettingsVariable;
use App\Tbuy\Settings\Models\Settings;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('type');
            $table->string('variable');
            $table->string('value');
            $table->softDeletes();
        });

        Settings::query()->insert([
            [
                'type' => SettingsType::SEARCH->value,
                'variable' => SettingsVariable::OUTPUT_COUNT->value,
                'value' => '20'
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
