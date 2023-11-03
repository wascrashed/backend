<?php

use App\Tbuy\CreditApplication\Enums\Status;
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
        Schema::create('bank_credit_application', function (Blueprint $table) {
            $table->foreignId('bank_id')->constrained();
            $table->foreignId('credit_application_id')->constrained();
            $table->decimal('sum', 12);
            $table->string('status')->default(Status::NEW->value);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_credit_application');
    }
};
