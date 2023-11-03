<?php

use App\Tbuy\Product\Enums\ProductType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Tbuy\Product\Enums\ProductStatus;
use Illuminate\Database\Eloquent\SoftDeletes;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->json('description')->nullable();
            $table->decimal('amount', 12);
            $table->decimal('price', 12);
            $table->enum('type', ProductType::values())->default(ProductType::DEFAULT->value);
            $table->boolean('active');
            $table->string('color');
            $table->decimal('size', 12);
            $table->boolean('before_declined')->default(false);
            $table->foreignId('brand_id')->constrained();
            $table->foreignId('category_id')->constrained();
            $table->dateTime('accepted_at')->nullable();
            $table->string('status')->default(ProductStatus::WAITING->value);
            $table->integer('update_count')->default(0);
            $table->unsignedInteger('views')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
