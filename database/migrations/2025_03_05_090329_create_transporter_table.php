<?php

use App\Models\TransporterType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transporters', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(TransporterType::class);
            $table->foreignId('user_id');
            $table->foreignId('operator_id')->nullable()->constrained('users');
            $table->longText('description')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->double('address_latitude')->nullable();
            $table->double('address_longitude')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transporters');
    }
};
