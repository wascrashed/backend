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
        Schema::create('model_field_references', function (Blueprint $table) {
            $table->id();
            $table->foreignId('model_list_id')->constrained();
            $table->string('model_field_id')->nullable();
            $table->string('foreign_model_field_id')->nullable();
            $table->string('foreign_model_field_type')->nullable();
            $table->string('relation_type')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_field_references');
    }
};
