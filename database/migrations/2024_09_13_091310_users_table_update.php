<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'memberName')) {
                $table->string('memberName')->nullable()->after('name');
            }
            if (!Schema::hasColumn('users', 'number')) {
                $table->string('number')->nullable()->after('memberName');
            }
            if (!Schema::hasColumn('users', 'companyName')) {
                $table->string('companyName')->nullable()->after('number');
            }
            if (!Schema::hasColumn('users', 'companyContact')) {
                $table->string('companyContact')->nullable()->after('companyName');
            }
            if (!Schema::hasColumn('users', 'companyNumber')) {
                $table->string('companyNumber')->nullable()->after('companyContact');
            }
            if (!Schema::hasColumn('users', 'website')) {
                $table->string('website')->nullable()->after('companyNumber');
            }
            if (!Schema::hasColumn('users', 'address')) {
                $table->text('address')->nullable()->after('website');
            }
            if (!Schema::hasColumn('users', 'status')) {
                $table->enum('status', ['active', 'inactive'])->default('active')->after('address');
            }
            if (!Schema::hasColumn('users', 'terms')) {
                $table->string('terms')->nullable()->after('status');
            }
            if (!Schema::hasColumn('users', 'type')) {
                $table->string('type')->nullable()->after('terms');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('memberName');
            $table->dropColumn('number');
            $table->dropColumn('companyName');
            $table->dropColumn('companyContact');
            $table->dropColumn('companyNumber');
            $table->dropColumn('website');
            $table->dropColumn('address');
            $table->dropColumn('status');
            $table->dropColumn('terms');
            $table->dropColumn('type');
        });
    }
};
