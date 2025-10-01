<?php

use App\Models\EquipmentType;
use App\Models\MachineryType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('machineries', function (Blueprint $table) {
            $table->dropColumn('codes_and_descriptions_id');
            $table->foreignIdFor(MachineryType::class)->after('id');
        });
        Schema::table('equipment', function (Blueprint $table) {
            $table->dropColumn('codes_and_descriptions_id');
            $table->foreignIdFor(EquipmentType::class)->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('machineries', function (Blueprint $table) {
            $table->dropColumn('machinery_type_id');
        });
        Schema::table('equipment', function (Blueprint $table) {
            $table->dropColumn('equipment_type_id');
        });
    }

};
