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
        Schema::create('search_ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ratingable_id');
            $table->string('ratingable_type');
            $table->decimal('rating', 12);
            $table->timestamps();

            $table->unique(['ratingable_id', 'ratingable_type'], 'ratingable');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('search_ratings');
    }
};
