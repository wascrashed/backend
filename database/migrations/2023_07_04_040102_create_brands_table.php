<?php

use App\Tbuy\Brand\Enums\BrandStatus;
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
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->foreignId('company_id')->constrained('companies');
            $table->foreignId('country_id')->constrained('countries');
            $table->date('date');
            $table->json('description');
            $table->string('status')->default(BrandStatus::PENDING->value);
            $table->dateTime('accepted_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
