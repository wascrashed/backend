<?php

use App\Tbuy\Audience\Enums\Gender;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('audiences', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->foreignId('company_id')->constrained('companies');
            $table->foreignId('country_id')->constrained('countries');
            $table->foreignId('region_id')->constrained('regions');

            $table->string('gender')->default(Gender::ALL->value);
            $table->json('age');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audiences');
    }
};
