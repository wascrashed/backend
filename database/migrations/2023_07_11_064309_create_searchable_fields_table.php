<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('searchable_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('model_field_id')->constrained();
            $table->foreignId('searchable_model_id')->constrained();
            $table->integer('priority');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('searchable_fields');
    }
};
