<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('mechanics', function (Blueprint $table) {
            $table->double('address_latitude')->nullable();
            $table->double('address_longitude')->nullable();
            $table->double('address')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('mechanics', function (Blueprint $table) {
            $table->dropColumn('address_latitude');
            $table->dropColumn('address_longitude');
            $table->dropColumn('address');
        });
    }
};
