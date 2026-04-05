<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ivs_streams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('button_label')->default('Watch Now');
            $table->text('ivs_url');
            $table->boolean('status')->default(false);
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->json('allowed_types')->nullable();
            $table->boolean('allow_vip')->default(false);
            $table->boolean('allow_all_members')->default(false);
            $table->boolean('allow_admin')->default(true);
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ivs_streams');
    }
};
