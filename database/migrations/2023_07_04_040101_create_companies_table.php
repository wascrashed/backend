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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->string('legal_name_company')->nullable();
            $table->json('description')->nullable();
            $table->string('type');
            $table->string('inn');
            $table->string('company_address')->nullable();
            $table->json('director');
            $table->json('phones')->nullable();
            $table->string('email');
            $table->timestamp('registered_at');
            $table->string('slug')->unique();
            $table->foreignId('parent_id')->nullable();
            $table->string('status');
            $table->boolean('legal_entity')->default(true);
            $table->foreignId('user_id')->constrained();
            $table->json('socials')->nullable();
            $table->string('tariff')->nullable();
            $table->string('balance')->nullable();
            $table->string('rating')->nullable();
            $table->string('bank_account')->unique()->nullable();
            $table->timestamp('tariff_conditions_accepted_at')->nullable();
            $table->timestamp('basic_agreement_accepted_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
