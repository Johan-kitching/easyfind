<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('machinery_availabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('machinery_id')->constrained('machineries');
            $table->string('start_date');
            $table->string('end_date');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('machinery_availabilities');
    }
};
