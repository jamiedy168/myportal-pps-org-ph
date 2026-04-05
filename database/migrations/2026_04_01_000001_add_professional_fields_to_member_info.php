<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('tbl_member_info')) {
            Schema::table('tbl_member_info', function (Blueprint $table) {
                $table->string('primary_institution')->nullable()->after('member_chapter');
                $table->string('specialty')->nullable()->after('primary_institution');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('tbl_member_info')) {
            Schema::table('tbl_member_info', function (Blueprint $table) {
                $table->dropColumn(['primary_institution', 'specialty']);
            });
        }
    }
};
