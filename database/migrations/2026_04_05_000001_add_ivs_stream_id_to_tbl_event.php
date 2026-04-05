<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_event', function (Blueprint $table) {
            $table->unsignedBigInteger('ivs_stream_id')->nullable()->after('youtube_live_url');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_event', function (Blueprint $table) {
            $table->dropColumn('ivs_stream_id');
        });
    }
};
