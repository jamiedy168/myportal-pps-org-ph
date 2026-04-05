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
                $table->date('induction_date')->nullable()->after('specialty');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('tbl_member_info')) {
            Schema::table('tbl_member_info', function (Blueprint $table) {
                $table->dropColumn('induction_date');
            });
        }
    }
};
