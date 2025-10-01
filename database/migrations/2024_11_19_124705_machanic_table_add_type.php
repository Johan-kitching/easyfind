<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('mechanics', function (Blueprint $table) {
            $table->foreignId('mechanic_type_id')->constrained('mechanic_type');
        });
    }

    public function down(): void
    {
        Schema::table('mechanics', function (Blueprint $table) {
            //
            $table->dropColumn('mechanic_type_id');
        });
    }
};
