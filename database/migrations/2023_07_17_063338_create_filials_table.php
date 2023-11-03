<?php

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
        Schema::create('filials', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->string('phone');
            $table->string('address');
            $table->string('coordinates');
            $table->json('schedule');
            $table->boolean('is_main');
            $table->foreignId('company_id')->constrained();
            $table->foreignId('region_id')->constrained();
            $table->foreignId('community_id')->constrained();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filials');
    }
};
