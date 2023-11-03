<?php

use App\Tbuy\Target\Enums\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('targets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('audience_id')->constrained('audiences');
            $table->morphs('targetable');

            $table->string('name');
            $table->string('link');
            $table->integer('duration');
            $table->string('status')->default(Status::NEW->value);
            $table->unsignedInteger('views')->default(0);

            $table->timestamp('started_at');
            $table->timestamp('finished_at');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('targets');
    }
};
