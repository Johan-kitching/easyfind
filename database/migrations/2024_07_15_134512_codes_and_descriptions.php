<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('codes_and_descriptions', function (Blueprint $table) {
            $table->id();
            $table->string('mmcode');
            $table->string('vehicle_type');
            $table->string('make');
            $table->string('model');
            $table->string('variant');
            $table->string('reg_year');
            $table->string('publication_section');
            $table->string('master_model');
            $table->string('make_code');
            $table->string('model_code');
            $table->string('variant_code');
            $table->string('axle_configuration');
            $table->string('body_type');
            $table->string('no_of_doors');
            $table->string('drive');
            $table->string('seats');
            $table->string('use');
            $table->string('wheelbase');
            $table->string('manual_auto');
            $table->string('no_gears');
            $table->string('cooling');
            $table->string('cubic_capacity');
            $table->string('cyl_configuration');
            $table->string('engine_cycle');
            $table->string('fuel_tank_size');
            $table->string('fuel_type');
            $table->string('kilowatts');
            $table->string('no_cylinders');
            $table->string('turbo_or_super_charged');
            $table->string('gcm');
            $table->string('gvm');
            $table->string('tare');
            $table->string('origin');
            $table->string('front_no_tyres');
            $table->string('front_tyre_size');
            $table->string('rear_no_tyres');
            $table->string('rear_tyre_size');
            $table->string('intro_date');
            $table->string('disc_date');
            $table->string('co_2');
            $table->string('length');
            $table->string('height');
            $table->string('width');
            $table->string('new_list_price');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('codes_and_descriptions');
    }
};
