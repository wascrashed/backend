<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\SoftDeletes;
return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('locales', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('locale');
            $table->boolean('is_main')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        \App\Tbuy\Locale\Models\Locale::query()->insert([
            [
                'name' => 'Русский',
                'locale' => 'ru',
                'is_main' => true
            ],
            [
                'name' => 'Английский',
                'locale' => 'en',
                'is_main' => false
            ],
            [
                'name' => 'Армянский',
                'locale' => 'hy',
                'is_main' => false
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locales');
    }
};
