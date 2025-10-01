<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
            $table->string('type')->nullable();
            $table->string('terms')->nullable();
            $table->string('number')->nullable()->after('type');
            $table->string('companyName')->nullable()->after('number');
            $table->string('companyContact')->nullable()->after('companyName');
            $table->string('companyNumber')->nullable()->after('companyContact');
            $table->string('website')->nullable()->after('companyNumber');
            $table->text('address')->nullable()->after('website');
            $table->enum('status',['active','inactive'])->default('active')->after('address');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn('number');
            $table->dropColumn('companyName');
            $table->dropColumn('companyContact');
            $table->dropColumn('companyNumber');
            $table->dropColumn('website');
            $table->dropColumn('address');
            $table->dropColumn('type');
            $table->dropColumn('terms');
            $table->dropColumn('status');
            $table->string('name')->change();
        });
    }
};
